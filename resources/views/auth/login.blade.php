<x-layout>
    <div class="max-w-sm mx-auto mt-10 bg-base-200 p-8 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-4 text-center">Logowanie</h2>
        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="label">Email</label>
                <input name="email" type="email" class="input input-bordered w-full" required />
            </div>
            <div class="mb-4">
                <label class="label">Hasło</label>
                <input name="password" type="password" class="input input-bordered w-full" required />
            </div>
            <button class="btn btn-primary w-full">Zaloguj się</button>
        </form>
        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="link">Nie masz konta? Zarejestruj się</a>
        </div>
    </div>
</x-layout>
