<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Recipe;
use App\Models\User;

class FavoriteService
{
    public function getUserFavorites(User $user)
    {
        //kolekcja przeisów a nie polubień jest zwracana (bo pluck)
        return $user->favorites()
            ->with('recipe.cuisine', 'recipe.mealType')
            ->latest()
            ->get()
            ->pluck('recipe');//pluck pobiera tylko rzeczy z pola recipe, używając do tego realcji
    }

    //przełącznik do polubienia przepisow
    public function toggleFavorite(User $user, Recipe $recipe)
    {
        $fav = Favorite::where('user_id', $user->id)
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($fav) {
            //jeśli w ulubionyc to usuń; else dodaj jak nie ma
            $fav->delete();
            return false;
        } else {
            Favorite::create(['user_id' => $user->id, 'recipe_id' => $recipe->id]);
            return true;
        }
    }
}
