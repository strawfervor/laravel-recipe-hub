<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Cuisine;
use App\Models\MealType;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Services\RecipeService;

class RecipeController extends Controller
{
    protected $service;

    public function __construct(RecipeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $recipes = $this->service->getAllWithFilters($request->all());
        $cuisines = Cuisine::orderBy('name')->get();
        $mealTypes = MealType::orderBy('name')->get();

        return view('recipes.index', [
            'recipes' => $recipes,
            'cuisines' => $cuisines,
            'mealTypes' => $mealTypes,
            'selectedCuisine' => $request->query('cuisine_id'),
            'selectedMealType' => $request->query('meal_type_id'),
            'q' => $request->query('q'),
        ]);
    }

    public function create()
    {
        $cuisines = Cuisine::orderBy('name')->get();
        $mealTypes = MealType::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        return view('recipes.create', compact('cuisines', 'mealTypes', 'ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'short_description' => ['required', 'max:1000'],
            'instructions' => ['required'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'cuisine_id' => ['nullable', 'exists:cuisines,id'],
            'meal_type_id' => ['nullable', 'exists:meal_types,id'],
            'difficulty' => ['required', 'integer', 'min:1', 'max:5'],
            'ingredients' => ['required', 'array', 'min:1'],
            'ingredients.*.id' => ['required', 'exists:ingredients,id'],
            'ingredients.*.amount' => ['required', 'integer', 'min:1'],
        ]);
        $data = $request->only([
            'title', 'short_description', 'instructions', 'image_url',
            'cuisine_id', 'meal_type_id', 'difficulty'
        ]);
        $this->service->create($data, $validated['ingredients']);
        return redirect()->route('recipes.index')->with('success', 'Dodano przepis!');
    }

    public function edit(Recipe $recipe)
    {
        $cuisines = Cuisine::orderBy('name')->get();
        $mealTypes = MealType::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        return view('recipes.edit', compact('recipe', 'cuisines', 'mealTypes', 'ingredients'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:100'],
            'short_description' => ['required','min:15', 'max:1000'],
            'instructions' => ['required'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'cuisine_id' => ['nullable', 'exists:cuisines,id'],
            'meal_type_id' => ['nullable', 'exists:meal_types,id'],
            'difficulty' => ['required', 'integer', 'min:1', 'max:5'],
        ]);
        $this->service->update($recipe, $validated);
        return redirect()->route('recipes.index')->with('success', 'Przepis zaktualizowany!');
    }

    public function destroy(Recipe $recipe)
    {
        $this->service->delete($recipe);
        return redirect()->route('recipes.index')->with('success', 'Przepis usunięty!');
    }

    public function show(Recipe $recipe)
    {
        $recipe = $this->service->getWithRelations($recipe);
        $avgRating = $this->service->getAvgRating($recipe);
        return view('recipes.show', compact('recipe', 'avgRating'));
    }
}
