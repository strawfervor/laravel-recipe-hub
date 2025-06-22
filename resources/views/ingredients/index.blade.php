<x-layout>
    <div class="max-w-2xl mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Lista składników</h1>
            <a href="{{ route('ingredients.create') }}" class="btn btn-primary">Dodaj składnik</a>
        </div>

        <form method="get" class="mb-4 flex gap-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="Szukaj składnika..." class="input input-bordered w-full max-w-xs" />
            <button class="btn">Szukaj</button>
        </form>

        @if(session('success'))
            <div class="alert alert-success mb-2">{{ session('success') }}</div>
        @endif

        <table class="table w-full bg-base-100 shadow rounded">
            <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Jednostka</th>
                    <th>Kcal / 100g</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ingredients as $i)
                <tr>
                    <td>{{ $i->name }}</td>
                    <td>{{ $i->unit }}</td>
                    <td>{{ $i->kcal_per_100g }}</td>
                    <td class="flex gap-2">
                        <a href="{{ route('ingredients.edit', $i) }}" class="btn btn-xs">Edytuj</a>
                        <form method="POST" action="{{ route('ingredients.destroy', $i) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-xs btn-error" onclick="return confirm('Usunąć składnik?')">Usuń</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4">Brak składników.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $ingredients->links() }}
        </div>
    </div>
</x-layout>
