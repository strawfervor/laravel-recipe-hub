<x-layout>
    <div class="max-w-xl mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Kuchnie</h1>
            <a href="{{ route('cuisines.create') }}" class="btn btn-primary">Dodaj kuchnię</a>
        </div>
        <form method="GET" class="mb-4 flex gap-2">
    <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Szukaj kuchni..."
        class="input input-bordered" />
    <button class="btn">Filtruj</button>
</form>
        @if(session('success'))
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
                @forelse ($cuisines as $cuisine)
                    <tr>
                        <td>{{ $cuisine->name }}</td>
                        <td class="flex gap-2">
                            <a href="{{ route('cuisines.edit', $cuisine) }}" class="btn btn-xs">Edytuj</a>
                            <form method="POST" action="{{ route('cuisines.destroy', $cuisine) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-error" onclick="return confirm('Usunąć?')">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2">Brak kuchni.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $cuisines->links() }}</div>
    </div>
</x-layout>
