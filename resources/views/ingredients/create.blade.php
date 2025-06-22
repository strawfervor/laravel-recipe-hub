<x-layout>
    <div class="max-w-lg mx-auto mt-8 bg-base-200 p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">Dodaj składnik</h2>
        @if($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('ingredients.store') }}">
            @csrf
            <div class="mb-4">
                <label class="label">Nazwa składnika</label>
                <input name="name" value="{{ old('name') }}" class="input input-bordered w-full" required>
            </div>
            <div class="mb-4">
                <label class="label">Jednostka (np. g, ml, szt.)</label>
                <input name="unit" value="{{ old('unit') }}" class="input input-bordered w-full" required>
            </div>
            <div class="mb-4">
                <label class="label">Kalorie na 100g</label>
                <input name="kcal_per_100g" type="number" min="0" max="2000" value="{{ old('kcal_per_100g') }}" class="input input-bordered w-full" required>
            </div>
            <div class="flex gap-2">
                <button class="btn btn-primary">Dodaj</button>
                <a href="{{ route('ingredients.index') }}" class="btn">Anuluj</a>
            </div>
        </form>
    </div>
</x-layout>
