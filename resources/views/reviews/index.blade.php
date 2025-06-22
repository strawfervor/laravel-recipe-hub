<x-layout>

<h2 class="text-2xl font-bold mb-4">Moje recenzje:</h2>

@if (!Model.Any())
{
    <p>Nie masz jeszcze żadnych recenzji.</p>
}
else
{
    <div class="flex flex-col gap-4">
        @foreach (var rec in Model)
        {
            <div class="card bg-base-200 shadow-md p-4">
                <h3 class="text-lg font-semibold">@rec.Przepis.Tytul</h3>
                <p class="text-sm text-gray-500">@rec.DataDodania.ToShortDateString()</p>
                <p>@rec.Tresc</p>
            </div>
        }
    </div>
}

</x-layout>