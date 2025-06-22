<?php

namespace App\Services;

use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class RecipeService
{
    public function getAllWithFilters($params)
    {
        $selectedCuisine = $params['cuisine_id'] ?? null;
        $selectedMealType = $params['meal_type_id'] ?? null;
        $q = $params['q'] ?? null;

        return Recipe::with(['cuisine', 'mealType'])
            ->when($selectedCuisine, fn($qB) => $qB->where('cuisine_id', $selectedCuisine))
            ->when($selectedMealType, fn($qB) => $qB->where('meal_type_id', $selectedMealType))
            ->when($q, fn($qB) => $qB->where(function ($x) use ($q) {
                $x->where('title', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%");
            }))
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();
    }

    public function create(array $data, array $ingredients)
    {
        $recipe = Recipe::create($data + [
            'user_id' => Auth::id(),
            'is_active' => true,
        ]);
        // Dodanie składników
        $attachData = [];
        foreach ($ingredients as $ingredient) {
            $attachData[$ingredient['id']] = ['amount' => $ingredient['amount']];
        }
        $recipe->ingredients()->attach($attachData);
        return $recipe;
    }

    public function update(Recipe $recipe, array $data)
    {
        return $recipe->update($data);
    }

    public function delete(Recipe $recipe)
    {
        return $recipe->delete();
    }

    public function getWithRelations(Recipe $recipe)
    {
        return $recipe->load(['ingredients', 'cuisine', 'mealType', 'user', 'reviews.user']);
    }

    public function getAvgRating(Recipe $recipe)
    {
        return $recipe->reviews()->avg('rating');
    }

    public function getTotalKcal(Recipe $recipe)
{
    $total = 0;
    foreach ($recipe->ingredients as $ingredient) {
        //amount = ilość w gramach/ml
        $amount = $ingredient->pivot->amount;
        $kcal_per_100g = $ingredient->kcal_per_100g ?: 0;
        $total += ($amount / 100) * $kcal_per_100g;
    }
    return round($total, 2);
}
}
