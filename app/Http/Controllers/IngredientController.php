<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $ingredients = Ingredient::when($q, fn($query) =>
            $query->where('name', 'like', "%$q%")
        )->orderBy('name')->paginate(10);

        return view('ingredients.index', compact('ingredients', 'q'));
    }

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:128', 'unique:ingredients,name'],
            'unit' => ['required', 'max:16'],
            'kcal_per_100g' => ['required', 'integer', 'min:0', 'max:2000'],
        ]);
        Ingredient::create($request->only(['name', 'unit', 'kcal_per_100g']));
        return redirect()->route('ingredients.index')->with('success', 'Dodano składnik.');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => ['required', 'max:128', 'unique:ingredients,name,'.$ingredient->id],
            'unit' => ['required', 'max:16'],
            'kcal_per_100g' => ['required', 'integer', 'min:0', 'max:2000'],
        ]);
        $ingredient->update($request->only(['name', 'unit', 'kcal_per_100g']));
        return redirect()->route('ingredients.index')->with('success', 'Zmieniono składnik.');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('ingredients.index')->with('success', 'Usunięto składnik.');
    }
}