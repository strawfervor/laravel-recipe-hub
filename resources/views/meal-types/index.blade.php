<x-layout>
    <div class="max-w-xl mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Rodzaje posiłku</h1>
            <a href="{{ route('meal-types.create') }}" class="btn btn-primary">Dodaj rodzaj posiłku</a>
        </div>
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Szukaj rodzaju..."
                class="input input-bordered" />
            <button class="btn">Filtruj</button>
        </form>

        @if (session('success'))
            <div class="alert alert-success mb-2">{{ session('success') }}</div>
        @endif
        <table class="table w-full bg-base-100 shadow rounded">
            <thead>
                <tr>
                    <th>Nazwa</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mealTypes as $meal_type)
                    <tr>
                        <td>{{ $meal_type->name }}</td>
                        <td class="flex gap-2">
                            <a href="{{ route('meal-types.edit', $meal_type) }}" class="btn btn-xs">Edytuj</a>
                            <form method="POST" action="{{ route('meal-types.destroy', $meal_type) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-error" onclick="return confirm('Usunąć?')">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Brak rodzajów posiłku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $mealTypes->links() }}</div>
    </div>
</x-layout>
