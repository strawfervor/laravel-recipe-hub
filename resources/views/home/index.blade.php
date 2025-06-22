<x-layout>

    <div class="hero bg-base-200 py-10 rounded-lg">
        <div class="hero-content text-center">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-bold mb-4">Przepisy</h1>
                <p class="text-lg text-gray-500">
                    Witaj na stronie poświęconej wspaniałym przepisom.
                </p>
                <p class="text-lg text-gray-500">
                    Tutaj każdy znajedzie dla siebie coś pysznego!
                </p>
            </div>
        </div>
    </div>

    <h1 class="text-3xl font-bold mt-4 mb-4">Najnowsze przepisy: </h1>
    <x-newestRecipes :recipes="$najnowszePrzepisy" />
</x-layout>
