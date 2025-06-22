<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Cuisine;
use App\Models\MealType;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $selectedCuisine = $request->query('cuisine_id');
        $selectedMealType = $request->query('meal_type_id');
        $q = $request->query('q');

        $recipes = Recipe::with(['cuisine', 'mealType'])
            ->when($selectedCuisine, fn($qB) => $qB->where('cuisine_id', $selectedCuisine))
            ->when($selectedMealType, fn($qB) => $qB->where('meal_type_id', $selectedMealType))
            ->when($q, fn($qB) => $qB->where(function ($x) use ($q) {
                $x->where('title', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%");
            }))
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $cuisines = Cuisine::orderBy('name')->get();
        $mealTypes = MealType::orderBy('name')->get();

        return view('recipes.index', compact(
            'recipes',
            'cuisines',
            'mealTypes',
            'selectedCuisine',
            'selectedMealType',
            'q'
        ));
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
        $request->validate([
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
        $recipe = Recipe::create([
            ...$request->only([
                'title',
                'short_description',
                'instructions',
                'image_url',
                'cuisine_id',
                'meal_type_id',
                'difficulty'
            ]),
            'user_id' => Auth::id(),
            'is_active' => true,
        ]);

        //dodanie składników
        $attachData = [];
        foreach ($request->input('ingredients') as $ingredient) {
            $attachData[$ingredient['id']] = ['amount' => $ingredient['amount']];
        }
        $recipe->ingredients()->attach($attachData);

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
        $request->validate([
            'title' => ['required', 'max:100'],
            'short_description' => ['required','min:15', 'max:1000'],
            'instructions' => ['required'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'cuisine_id' => ['nullable', 'exists:cuisines,id'],
            'meal_type_id' => ['nullable', 'exists:meal_types,id'],
            'difficulty' => ['required', 'integer', 'min:1', 'max:5'],
        ]);
        $recipe->update($request->only([
            'title',
            'short_description',
            'instructions',
            'image_url',
            'cuisine_id',
            'meal_type_id',
            'difficulty'
        ]));
        return redirect()->route('recipes.index')->with('success', 'Przepis zaktualizowany!');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Przepis usunięty!');
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['ingredients', 'cuisine', 'mealType', 'user', 'reviews.user']);
        $avgRating = $recipe->reviews()->avg('rating');
        return view('recipes.show', compact('recipe', 'avgRating'));
    }
}
