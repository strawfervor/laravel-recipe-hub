<x-layout>
    <div class="max-w-md mx-auto mt-8 bg-base-200 p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">Dodaj rodzaj posiłku</h2>
        @if($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('meal-types.store') }}">
            @csrf
            <div class="mb-4">
                <label class="label">Nazwa rodzaju posiłku</label>
                <input name="name" value="{{ old('name') }}" class="input input-bordered w-full" required>
            </div>
            <div class="flex gap-2">
                <button class="btn btn-primary">Dodaj</button>
                <a href="{{ route('meal-types.index') }}" class="btn">Anuluj</a>
            </div>
        </form>
    </div>
</x-layout>
