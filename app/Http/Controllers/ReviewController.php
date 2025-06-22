<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Services\ReviewService;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    protected $service;

    public function __construct(ReviewService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'content' => ['required', 'min:6'],
        ]);

        $added = $this->service->addReview($recipe, $validated);

        // Możesz pokazać komunikat
        if (!$added) {
            return back()->with('error', 'Już dodałeś opinię do tego przepisu.');
        }

        return back()->with('success', 'Opinia dodana!');
    }

    public function index(Request $request)
    {
        $search = $request->query('q');
        $userId = Auth::id();
        $reviews = $this->service->getUserReviews($userId, $search);

        return view('reviews.index', compact('reviews', 'search'));
    }

    public function destroy($id)
    {
        $userId = Auth::id();
        $deleted = $this->service->deleteUserReview($id, $userId);

        if ($deleted) {
            return back()->with('success', 'Usunięto recenzję.');
        }
        return back()->with('error', 'Nie można usunąć tej recenzji.');
    }
}
