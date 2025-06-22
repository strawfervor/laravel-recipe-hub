<x-layout>
<div class="max-w-2xl mx-auto p-6 bg-base-200 rounded-xl shadow">
    <h2 class="text-3xl font-bold mb-6 text-center">Edytuj profil</h2>

    <form asp-action="Edit" enctype="multipart/form-data" method="post">
        <input type="hidden" asp-for="Id" />

        <div class="form-control mb-4">
            <label class="label"><span class="label-text">Nazwa użytkownika</span></label>
            <input asp-for="NazwaUzytkownika" class="input input-bordered w-full" readonly />
        </div>

        <div class="form-control mb-4">
            <label class="label"><span class="label-text">Opis</span></label>
            <textarea asp-for="Opis" class="textarea textarea-bordered w-full"></textarea>
        </div>

        <div class="form-control mb-4">
            <label class="label"><span class="label-text">Avatar</span></label>
            <input asp-for="Avatar" type="file" class="file-input file-input-bordered w-full" accept="image/*" />
        </div>

        <button type="submit" class="btn btn-secondary">Zapisz zmiany</button>
    </form>
</div>

</x-layout>