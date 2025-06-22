<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        // Pobieramy przepisy polubione przez usera
        $recipes = $user->favorites()->with('recipe.cuisine', 'recipe.mealType')->latest()->get()->pluck('recipe');

        return view('favorites.index', compact('recipes'));
    }

    public function toggle(Recipe $recipe)
    {
        //przełączanie ulubione/nie ulubione
        $user = Auth::user();
        $fav = Favorite::where('user_id', $user->id)->where('recipe_id', $recipe->id)->first();

        if ($fav) {
            $fav->delete();
            return back();
        } else {
            Favorite::create(['user_id' => $user->id, 'recipe_id' => $recipe->id]);
            return back();
        }
    }
}
