<x-layout>
<div class="max-w-3xl mx-auto p-6 bg-base-200 rounded-xl shadow">
    <h2 class="text-3xl font-bold mb-6 text-center">Mój profil</h2>

    <div class="flex items-center gap-6 mb-6">
        <img src="@Model.UrlAwataru" alt="Avatar" class="w-24 h-24 rounded-full object-cover border border-gray-300" />
        <div>
            <h3 class="text-xl font-semibold">@Model.NazwaUzytkownika</h3>
            <p class="text-sm text-gray-500">Rola: @Model.Rola?.Nazwa</p>
        </div>
    </div>

    <div>
        <h4 class="text-lg font-semibold mb-2">O mnie</h4>
        <p>@Model.Opis</p>
    </div>
    
    <div>
        <a asp-action="Edit" class="btn btn-outline btn-sm mt-4">Edytuj profil</a>
    </div>
</div>

</x-layout>