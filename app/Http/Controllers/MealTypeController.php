<?php

namespace App\Http\Controllers;

use App\Models\MealType;
use Illuminate\Http\Request;
use App\Services\MealTypeService;

class MealTypeController extends Controller
{
    protected $service;

    public function __construct(MealTypeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $q = $request->query('q');
        $mealTypes = $this->service->getAll($q);
        return view('meal-types.index', compact('mealTypes', 'q'));
    }

    public function create()
    {
        return view('meal-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:64', 'unique:meal_types,name']
        ]);
        $this->service->create($validated);
        return redirect()->route('meal-types.index')->with('success', 'Dodano rodzaj posiłku.');
    }

    public function edit(MealType $mealType)
    {
        return view('meal-types.edit', compact('mealType'));
    }

    public function update(Request $request, MealType $mealType)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:64', 'unique:meal_types,name,' . $mealType->id]
        ]);
        $this->service->update($mealType, $validated);
        return redirect()->route('meal-types.index')->with('success', 'Zmieniono rodzaj posiłku.');
    }

    public function destroy(MealType $mealType)
    {
        $this->service->delete($mealType);
        return redirect()->route('meal-types.index')->with('success', 'Usunięto rodzaj posiłku.');
    }
}
