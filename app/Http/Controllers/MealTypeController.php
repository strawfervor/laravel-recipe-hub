<?php

namespace App\Http\Controllers;

use App\Models\MealType;
use Illuminate\Http\Request;

class MealTypeController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $mealTypes = MealType::when(
            $q,
            fn($query) =>
            $query->where('name', 'like', "%$q%")
        )->orderBy('name')->paginate(10)->withQueryString();

        return view('meal-types.index', compact('mealTypes', 'q'));
    }

    public function create()
    {
        // widok: resources/views/meal-types/create.blade.php
        return view('meal-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:64', 'unique:meal_types,name']
        ]);
        MealType::create($request->only('name'));
        return redirect()->route('meal-types.index')->with('success', 'Dodano rodzaj posiłku.');
    }

    public function edit(MealType $mealType)
    {
        // widok: resources/views/meal-types/edit.blade.php
        return view('meal-types.edit', compact('mealType'));
    }

    public function update(Request $request, MealType $mealType)
    {
        $request->validate([
            'name' => ['required', 'max:64', 'unique:meal_types,name,' . $mealType->id]
        ]);
        $mealType->update($request->only('name'));
        return redirect()->route('meal-types.index')->with('success', 'Zmieniono rodzaj posiłku.');
    }

    public function destroy(MealType $mealType)
    {
        $mealType->delete();
        return redirect()->route('meal-types.index')->with('success', 'Usunięto rodzaj posiłku.');
    }
}
