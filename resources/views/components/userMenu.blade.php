@auth
<li>
    <a href="{{ route('recipes.create') }}" >Dodaj przepis</a>
</li>
<li>
    <details>
        <summary>Zarządzanie</summary>
        <ul class="bg-base-100 rounded-t-none p-2">
            <li>
                <a href="{{ route('ingredients.index') }}" >Składniki</a>
            </li>
            <li>
                <a href="{{ route('cuisines.index') }}" >Kuchnie</a>
            </li>
            <li>
                <a href="{{ route('meal-types.index') }}" >Rodzaje posiłków</a>
            </li>
        </ul>
    </details>
</li>
<li>
    <details>
        <summary>Użytkownik</summary>
        <ul class="bg-base-100 rounded-t-none p-2">
            <li>
                <a href="{{ route('favorites.index') }}" >Ulubione przepisy</a>
            </li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <li><button type="submit" >Wyloguj</button></li>
            </form>
        </ul>
    </details>
</li>
@else
    <li><a href="{{ route('login') }}" >Zaloguj się</a></li>
    <li><a href="{{ route('register') }}" >Zarejestruj się</a></li>
@endauth
