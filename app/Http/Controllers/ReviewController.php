<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    //obsługuje tylko store
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'content' => ['required', 'min:3'],
        ]);
        //ograniczenie do jednej opini na usera
        $userId = Auth::id();
        if ($recipe->reviews()->where('user_id', $userId)->exists()) {
            return back();
        }

        $recipe->reviews()->create([
            'user_id' => $userId,
            'rating' => $request->rating,
            'content' => $request->content,
        ]);
        return back();
    }
}