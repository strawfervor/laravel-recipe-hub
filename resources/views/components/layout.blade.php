<!DOCTYPE html>
<html lang="pl" data-theme="caramellatte">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Przepisy</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
</head>

<body class="flex flex-col min-h-screen">

    <!-- menu -->
    <header>
        <div class="navbar bg-base-100 shadow-sm">
            <div class="flex-1">
                <a class="btn btn-ghost text-xl" href="/">Przepisy</a>
            </div>

            <!-- menu przeglądarkowe -->
            <div class="flex-none hidden lg:block">
                <ul class="menu menu-horizontal px-1">
                    <!-- @await Html.PartialAsync("Odnosniki", ViewBag.ModelStrony as IEnumerable<Strona>) -->
                    <li><a href="{{ route('recipes.index') }}">Przepisy</a></li>
                    <x-userMenu />
                </ul>
            </div>

            <!-- menu telefony -->
            <div class="flex-none lg:hidden">
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a asp-controller="Przepisy" asp-action="Index">Przepisy</a></li>
                            <li><a asp-controller="Przepisy" asp-action="Create">Dodaj przepis</a></li>
                            <li class="border-t mt-2 pt-2"><a>Mój profil</a></li>
                            <li><a asp-controller="Ulubione" asp-action="Index">Ulubione przepisy</a></li>
                            <li><a asp-controller="Recenzje" asp-action="Index">Recenzje</a></li>
                            <li><a>Wyloguj</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 p-6 max-w-7xl mx-auto w-full">
        {{ $slot }}
    </main>

    <footer class="footer footer-center bg-base-300 text-base-content p-4">
        <aside>

            <!-- ewenetuialnie wyświetlić: <p>Stopka.Tresc</p> -->

            <p>©2025 - Przepisy</p>

        </aside>
    </footer>
</body>

</html>
