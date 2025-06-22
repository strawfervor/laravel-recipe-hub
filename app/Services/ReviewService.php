<?php

namespace App\Services;

use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    public function addReview(Recipe $recipe, array $data): bool
    {
        $userId = Auth::id();
        //sprawdzanie czy user nie dodał już opini
        if ($recipe->reviews()->where('user_id', $userId)->exists()) {
            return false;
        }

        $recipe->reviews()->create([
            'user_id' => $userId,
            'rating' => $data['rating'],
            'content' => $data['content'],
        ]);
        return true;
    }
}
