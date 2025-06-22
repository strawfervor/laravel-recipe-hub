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

    public function getUserReviews($userId, $search = null)
    {
        $query = \App\Models\Review::with(['recipe.cuisine', 'recipe.mealType'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at');

        if ($search) {
            $query->where('content', 'like', "%$search%");
        }

        return $query->paginate(10)->withQueryString();
    }

    public function deleteUserReview($reviewId, $userId)
    {
        $review = \App\Models\Review::where('id', $reviewId)->where('user_id', $userId)->first();

        if ($review) {
            $review->delete();
            return true;
        }
        return false;
    }
}
