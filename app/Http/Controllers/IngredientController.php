<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Services\IngredientService;

class IngredientController extends Controller
{
    protected $service;

    public function __construct(IngredientService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $q = $request->query('q');
        $ingredients = $this->service->getAll($q);
        return view('ingredients.index', compact('ingredients', 'q'));
    }

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:128', 'unique:ingredients,name'],
            'unit' => ['required', 'max:16'],
            'kcal_per_100g' => ['required', 'integer', 'min:0', 'max:2000'],
        ]);
        $this->service->create($validated);
        return redirect()->route('ingredients.index')->with('success', 'Dodano składnik.');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:128', 'unique:ingredients,name,'.$ingredient->id],
            'unit' => ['required', 'max:16'],
            'kcal_per_100g' => ['required', 'integer', 'min:0', 'max:2000'],
        ]);
        $this->service->update($ingredient, $validated);
        return redirect()->route('ingredients.index')->with('success', 'Zmieniono składnik.');
    }

    public function destroy(Ingredient $ingredient)
    {
        $this->service->delete($ingredient);
        return redirect()->route('ingredients.index')->with('success', 'Usunięto składnik.');
    }
}
