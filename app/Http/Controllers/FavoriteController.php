<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Services\FavoriteService;

class FavoriteController extends Controller
{
    protected $service;

    public function __construct(FavoriteService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $recipes = $this->service->getUserFavorites($user);
        return view('favorites.index', compact('recipes'));
    }

    public function toggle(Recipe $recipe, Request $request)
    {
        $user = $request->user();
        $this->service->toggleFavorite($user, $recipe);
        return back();
    }
}
