<!--w kontrolerze w take się definiu ile ma wyświetlać najnowszych przepisów -->
<div class="flex flex-wrap justify-start mt-4 mb-4 gap-4">
    @foreach ($recipes as $recipe)
        <div class="card bg-base-100 w-80 shadow-sm">
            <figure>
                <img class="h-48 w-full object-cover" src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">{{ $recipe->title }}</h2>
                <p class="h-24 overflow-hidden">{{ $recipe->short_description }}</p>
                <div class="card-actions justify-end">
                    <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-primary">Pokaż</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
