<x-layout>
    <div class="max-w-xl mx-auto bg-base-200 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Dodaj przepis</h2>
        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('recipes.store') }}">
            @csrf
            <div class="mb-4">
                <label class="label">Tytuł</label>
                <input name="title" value="{{ old('title') }}" class="input input-bordered w-full" required>
            </div>
            <div class="mb-4">
                <label class="label">Krótki opis</label>
                <textarea name="short_description" class="textarea textarea-bordered w-full" required>{{ old('short_description') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="label">Składniki</label>
                <div id="ingredients-list">
                    <div class="flex gap-2 mb-2">
                        <select name="ingredients[0][id]" class="select select-bordered" required>
                            <option value="">składnik</option>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" min="1" name="ingredients[0][amount]" class="input input-bordered"
                            placeholder="ilość" required>
                    </div>
                </div>
                <button type="button" onclick="addIngredient()" class="btn btn-xs btn-outline mt-2">Dodaj
                    składnik</button>
            </div>
            <div class="mb-4">
                <label class="label">Opis wykonania</label>
                <textarea name="instructions" class="textarea textarea-bordered w-full" required>{{ old('instructions') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="label">Adres URL zdjęcia (opcjonalnie)</label>
                <input name="image_url" value="{{ old('image_url') }}" class="input input-bordered w-full">
            </div>
            <div class="mb-4">
                <label class="label">Kuchnia</label>
                <select name="cuisine_id" class="select select-bordered w-full">
                    <option value="">kuchnia</option>
                    @foreach ($cuisines as $cuisine)
                        <option value="{{ $cuisine->id }}" @selected(old('cuisine_id') == $cuisine->id)>{{ $cuisine->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="label">Rodzaj posiłku</label>
                <select name="meal_type_id" class="select select-bordered w-full">
                    <option value="">rodzaj posiłku</option>
                    @foreach ($mealTypes as $mealType)
                        <option value="{{ $mealType->id }}" @selected(old('meal_type_id') == $mealType->id)>{{ $mealType->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="label">Trudność (1-5)</label>
                <input type="number" name="difficulty" min="1" max="5"
                    value="{{ old('difficulty', 1) }}" class="input input-bordered w-full" required>
            </div>
            <div class="flex gap-2">
                <button class="btn btn-primary">Zapisz</button>
                <a href="{{ route('recipes.index') }}" class="btn">Anuluj</a>
            </div>
        </form>
    </div>

    <script>
        let ingredientIndex = 1;

        function addIngredient() {
            //skrypt wrzuca poniższy html, do listy skałdników (id = ingredients-list) i zwiększa licznik składkników
            const html = `
            <div class="flex gap-2 mb-2">
                <select name="ingredients[${ingredientIndex}][id]" class="select select-bordered" required>
                    <option value="">-- wybierz --</option>
                    @foreach ($ingredients as $ingredient)
                        <option value="{{ $ingredient->id }}">{{ $ingredient->name }} ({{ $ingredient->unit }})</option>
                    @endforeach
                </select>
                <input type="number" min="1" name="ingredients[${ingredientIndex}][amount]" class="input input-bordered" placeholder="ilość" required>
                <button type="button" onclick="this.parentNode.remove()" class="btn btn-xs btn-error">Usuń</button>
            </div>
            `;
            //wrzuć html przed końcem elelmentu o tym id
            document.getElementById('ingredients-list').insertAdjacentHTML('beforeend', html);
            ingredientIndex++;
        }
    </script>
</x-layout>
