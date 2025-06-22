<x-layout>
    <h1 class="text-2xl font-bold mb-4">Ulubione przepisy</h1>

    <div class="grid gap-6 mt-4 mb-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @forelse ($recipes as $recipe)
            <div class="card bg-base-100 shadow-md">
                @if ($recipe->image_url)
                    <figure class="h-48 overflow-hidden">
                        <img src="{{ $recipe->image_url }}" class="object-cover w-full h-full" />
                    </figure>
                @endif
                <div class="card-body">
                    <h2 class="card-title">{{ $recipe->title }}</h2>
                    <p class="text-sm">{{ $recipe->short_description }}</p>
                    <div class="text-xs text-gray-500 mt-1">
                        Kuchnia: {{ $recipe->cuisine->name ?? '-' }}<br>
                        Rodzaj: {{ $recipe->mealType->name ?? '-' }}
                    </div>
                    <div class="card-actions justify-end mt-2">
                        <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-primary btn-xs">Pokaż</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center text-gray-500">Brak ulubionych przepisów.</div>
        @endforelse
    </div>
</x-layout>
