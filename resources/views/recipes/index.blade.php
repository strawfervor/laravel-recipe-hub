<x-layout>
    <form method="get" class="mb-6 flex flex-wrap gap-4 items-end">
        <div class="form-control">
            <label class="label">
                <span class="label-text">Szukaj</span>
            </label>
            <input type="text" name="q" value="{{ $q ?? '' }}" class="input input-bordered"
                placeholder="Szukaj...">
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Rodzaj kuchni</span>
            </label>
            <select name="cuisine_id" class="select select-bordered">
                <option value="">Wszystkie</option>
                @foreach ($cuisines as $cuisine)
                    <option value="{{ $cuisine->id }}" @selected((string) $selectedCuisine === (string) $cuisine->id)>{{ $cuisine->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Rodzaj posiłku</span>
            </label>
            <select name="meal_type_id" class="select select-bordered">
                <option value="">Wszystkie</option>
                @foreach ($mealTypes as $mealType)
                    <option value="{{ $mealType->id }}" @selected((string) $selectedMealType === (string) $mealType->id)>{{ $mealType->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-secondary">Filtruj</button>
    </form>

    <div class="grid gap-6 mt-4 mb-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @forelse ($recipes as $recipe)
            <div class="card bg-base-100 shadow-md">
                @if ($recipe->image_url)
                    <figure class="h-48 overflow-hidden">
                        <img src="{{ $recipe->image_url }}" class="object-cover w-full h-full" />
                    </figure>
                @endif
                <div class="card-body">
                    <h2 class="card-title">{{ $recipe->title }}</h2>
                    <p class="text-sm">{{ $recipe->short_description }}</p>
                    <div class="text-xs text-gray-500 mt-1">
                        Kuchnia: {{ $recipe->cuisine->name ?? '-' }}<br>
                        Rodzaj: {{ $recipe->mealType->name ?? '-' }}
                    </div>
                    <div class="card-actions justify-end mt-2">
                        <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-primary btn-xs">Pokaż</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center text-gray-500">Brak przepisów.</div>
        @endforelse
    </div>

    <div class="w-full mt-10 pt-6 flex justify-center">
        {{ $recipes->appends(['q' => $q, 'cuisine_id' => $selectedCuisine, 'meal_type_id' => $selectedMealType])->links() }}
    </div>
</x-layout>
