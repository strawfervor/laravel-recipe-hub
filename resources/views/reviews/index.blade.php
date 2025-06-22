<x-layout>
    <div class="max-w-2xl mx-auto bg-base-200 p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Moje opinie</h1>
        <form method="get" class="mb-4 flex gap-2">
            <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Szukaj w treści..." class="input input-bordered w-full">
            <button class="btn btn-primary">Szukaj</button>
        </form>
        @if(session('success'))
            <div class="alert alert-success mb-2">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error mb-2">{{ session('error') }}</div>
        @endif
        @forelse($reviews as $review)
            <div class="mb-4 p-3 bg-base-100 rounded shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <strong>{{ $review->recipe->title }}</strong>
                        <span class="text-xs text-gray-500 ml-2">{{ $review->created_at->format('Y-m-d') }}</span>
                        <div class="text-yellow-500 font-bold">{{ $review->rating }}/5</div>
                    </div>
                    <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" onsubmit="return confirm('Usunąć recenzję?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-xs btn-error">Usuń</button>
                    </form>
                </div>
                <div class="mt-2">{{ $review->content }}</div>
                <div class="text-xs mt-1 text-gray-400">
                    Kuchnia: {{ $review->recipe->cuisine->name ?? '-' }},
                    Rodzaj: {{ $review->recipe->mealType->name ?? '-' }}
                </div>
            </div>
        @empty
            <div class="text-gray-500">Brak recenzji.</div>
        @endforelse

        <div class="mt-4">{{ $reviews->links() }}</div>
    </div>
</x-layout>
