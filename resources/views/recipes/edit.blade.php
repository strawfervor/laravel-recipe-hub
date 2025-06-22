<x-layout>
    <div class="max-w-xl mx-auto bg-base-200 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Edytuj przepis</h2>
        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('recipes.update', $recipe) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="label">Tytuł</label>
                <input name="title" value="{{ old('title', $recipe->title) }}" class="input input-bordered w-full" required>
            </div>
            <div class="mb-4">
                <label class="label">Krótki opis</label>
                <textarea name="short_description" class="textarea textarea-bordered w-full" required>{{ old('short_description', $recipe->short_description) }}</textarea>
            </div>
            <div class="mb-4">
                <label class="label">Składniki</label>
                <div id="ingredients-list">
                    @php $i = 0; @endphp
                    @foreach ($recipe->ingredients as $ing)
                        <div class="flex gap-2 mb-2">
                            <select name="ingredients[{{ $i }}][id]" class="select select-bordered" required>
                                <option value="">składnik</option>
                                @foreach ($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}"
                                        @selected(old("ingredients.$i.id", $ing->id) == $ingredient->id)>
                                        {{ $ingredient->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" min="1" name="ingredients[{{ $i }}][amount]"
                                class="input input-bordered"
                                placeholder="ilość"
                                value="{{ old("ingredients.$i.amount", $ing->pivot->amount) }}"
                                required>
                            <button type="button" onclick="this.parentNode.remove()" class="btn btn-xs btn-error">Usuń</button>
                        </div>
                        @php $i++; @endphp
                    @endforeach
                    {{--obsluga walidacji, nieudanych --}}
                    @if (old('ingredients') && count(old('ingredients')) > $i)
                        @for ($j = $i; $j < count(old('ingredients')); $j++)
                            <div class="flex gap-2 mb-2">
                                <select name="ingredients[{{ $j }}][id]" class="select select-bordered" required>
                                    <option value="">składnik</option>
                                    @foreach ($ingredients as $ingredient)
                                        <option value="{{ $ingredient->id }}"
                                            @selected(old("ingredients.$j.id") == $ingredient->id)>
                                            {{ $ingredient->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" min="1" name="ingredients[{{ $j }}][amount]"
                                    class="input input-bordered"
                                    placeholder="ilość"
                                    value="{{ old("ingredients.$j.amount") }}"
                                    required>
                                <button type="button" onclick="this.parentNode.remove()" class="btn btn-xs btn-error">Usuń</button>
                            </div>
                        @endfor
                    @endif
                </div>
                <button type="button" onclick="addIngredient()" class="btn btn-xs btn-outline mt-2">Dodaj składnik</button>
            </div>
            <div class="mb-4">
                <label class="label">Opis wykonania</label>
                <textarea name="instructions" class="textarea textarea-bordered w-full" required>{{ old('instructions', $recipe->instructions) }}</textarea>
            </div>
            <div class="mb-4">
                <label class="label">Adres URL zdjęcia (opcjonalnie)</label>
                <input name="image_url" value="{{ old('image_url', $recipe->image_url) }}" class="input input-bordered w-full">
            </div>
            <div class="mb-4">
                <label class="label">Kuchnia</label>
                <select name="cuisine_id" class="select select-bordered w-full">
                    <option value="">kuchnia</option>
                    @foreach ($cuisines as $cuisine)
                        <option value="{{ $cuisine->id }}" @selected(old('cuisine_id', $recipe->cuisine_id) == $cuisine->id)>{{ $cuisine->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="label">Rodzaj posiłku</label>
                <select name="meal_type_id" class="select select-bordered w-full">
                    <option value="">rodzaj posiłku</option>
                    @foreach ($mealTypes as $mealType)
                        <option value="{{ $mealType->id }}" @selected(old('meal_type_id', $recipe->meal_type_id) == $mealType->id)>{{ $mealType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="label">Trudność (1-5)</label>
                <input type="number" name="difficulty" min="1" max="5"
                    value="{{ old('difficulty', $recipe->difficulty) }}" class="input input-bordered w-full" required>
            </div>
            <div class="flex gap-2">
                <button class="btn btn-primary">Zapisz</button>
                <a href="{{ route('recipes.index') }}" class="btn">Anuluj</a>
            </div>
        </form>
    </div>

    <script>
        let ingredientIndex = {{ count($recipe->ingredients) }};
        function addIngredient() {
            const html = `
            <div class="flex gap-2 mb-2">
                <select name="ingredients[\${ingredientIndex}][id]" class="select select-bordered" required>
                    <option value="">składnik</option>
                    @foreach ($ingredients as $ingredient)
                        <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                    @endforeach
                </select>
                <input type="number" min="1" name="ingredients[\${ingredientIndex}][amount]" class="input input-bordered" placeholder="ilość" required>
                <button type="button" onclick="this.parentNode.remove()" class="btn btn-xs btn-error">Usuń</button>
            </div>
            `;
            //wrzuć html przed końcem elelmentu o tym id
            document.getElementById('ingredients-list').insertAdjacentHTML('beforeend', html);
            ingredientIndex++;
        }
    </script>
</x-layout>
