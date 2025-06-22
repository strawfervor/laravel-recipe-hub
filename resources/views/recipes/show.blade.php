@php
    //sprawdzanie czy user ocenił już przepis, żeby zmienić guzik na "odlubioanie"
    $isFav =
        auth()->check() &&
        $recipe
            ->favorites()
            ->where('user_id', auth()->id())
            ->exists();
@endphp

<x-layout>
    <div class="max-w-2xl mx-auto bg-base-200 p-6 rounded shadow">
        <h1 class="text-3xl font-bold mb-4">{{ $recipe->title }}</h1>
        @if ($recipe->image_url)
            <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" class="w-full h-64 object-cover mb-4 rounded" />
        @endif

        <div class="mb-2 text-gray-500">
            <span>Kuchnia: <strong>{{ $recipe->cuisine->name ?? '-' }}</strong></span> |
            <span>Rodzaj: <strong>{{ $recipe->mealType->name ?? '-' }}</strong></span> |
            <span>Trudność: <strong>{{ $recipe->difficulty }}</strong></span>
        </div>


        <div class="mb-2">
            <span class="text-sm">Autor: {{ $recipe->user->name ?? 'Brak' }}</span>
        </div>

        <!-- dodanie rpzpeisu do ulubionych -->
        <form method="POST" action="{{ route('recipes.favorite', $recipe) }}" class="inline-block">
            @csrf
            <button type="submit" class="btn btn-sm {{ $isFav ? 'btn-error' : 'btn-secondary' }}"
                title="{{ $isFav ? 'Usuń z ulubionych' : 'Dodaj do ulubionych' }}">
                @if ($isFav)
                    Lubisz ten przepis
                @else
                    Lubię ten przepis
                @endif
            </button>
        </form>

        <h2 class="text-xl font-semibold mb-2 mt-6">Opis:</h2>
        <p class="mb-4 text-lg">{{ $recipe->short_description }}</p>

        <div class="mb-2 text-lg">
            <span>Średnia ocena:
                @if ($avgRating)
                    <span class="text-yellow-500 font-bold">{{ number_format($avgRating, 2) }}/5</span>
                @else
                    <span class="text-gray-400">Brak ocen</span>
                @endif
            </span>
        </div>

        <h2 class="text-xl font-semibold mb-2">Składniki</h2>
        @if ($recipe->ingredients && $recipe->ingredients->count())
            <ul class="list-disc list-inside mb-4">
                @foreach ($recipe->ingredients as $ingredient)
                    <li>
                        {{ $ingredient->name }} – {{ $ingredient->pivot->amount }} {{ $ingredient->unit }}
                        <span class="text-xs text-gray-400">
                            ({{ $ingredient->kcal_per_100g ?? '-' }} kcal/100g)
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="mb-4 text-gray-400">Brak składników.</p>
        @endif

        <h2 class="text-xl font-semibold mb-2">Sposób przygotowania</h2>
        <p class="mb-6">{{ $recipe->instructions }}</p>


        <h2 class="text-xl font-semibold mb-4 mt-8">Recenzje</h2>

        @auth
            @php
                //sprawdzanie czy user ocenił już przepis
                $userReviewed = $recipe->reviews->where('user_id', auth()->id())->count() > 0;
            @endphp
            @if (!$userReviewed)
                <form method="POST" action="{{ route('reviews.store', $recipe) }}"
                    class="mb-6 bg-base-100 p-4 rounded shadow">
                    @csrf
                    <div class="mb-2">
                        <label class="label">Ocena (1-5)</label>
                        <input type="number" name="rating" min="1" max="5" class="input input-bordered"
                            required>
                    </div>
                    <div class="mb-2">
                        <label class="label">Komentarz</label>
                        <textarea name="content" class="textarea textarea-bordered w-full" required></textarea>
                    </div>
                    <button class="btn btn-primary">Dodaj recenzję</button>
                </form>
            @else
                <div class="mb-4 text-success">Już oceniłeś ten przepis.</div>
            @endif
        @endauth
        @guest
            <div class="alert alert-info mb-4">Zaloguj się, aby dodać recenzję.</div>
        @endguest

        @forelse ($recipe->reviews()->with('user')->latest()->get() as $review)
            <div class="mb-3 p-3 bg-base-100 rounded shadow">
                <div class="flex justify-between items-center mb-1">
                    <div>
                        <strong>{{ $review->user->name ?? 'Anonim' }}</strong>
                        <span class="text-xs text-gray-500 ml-2">{{ $review->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div>
                        <span class="text-yellow-500 font-bold">{{ $review->rating }}/5</span>
                    </div>
                </div>
                <div>{{ $review->content }}</div>
            </div>
        @empty
            <p class="text-gray-500">Brak recenzji.</p>
        @endforelse

        <div class="mt-6 flex gap-2">
            <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline btn-sm">Edytuj</a>
            <a href="{{ route('recipes.index') }}" class="btn btn-sm">Wróć</a>
            <!-- usuwanie przpeisu -->
            @auth
                @if (auth()->id() === $recipe->user_id)
                    <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" class="inline-block"
                        onsubmit="return confirm('Usunąć ten przepis?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-error btn-sm">Usuń</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</x-layout>
