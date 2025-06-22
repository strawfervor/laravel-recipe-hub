<?php

namespace App\Http\Controllers;

use App\Models\Cuisine;
use Illuminate\Http\Request;
use App\Services\CuisineService;

class CuisineController extends Controller
{
    protected $service;

    public function __construct(CuisineService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $q = $request->query('q');
        $cuisines = $this->service->getAll($q);
        return view('cuisines.index', compact('cuisines', 'q'));
    }

    public function create()
    {
        return view('cuisines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:64', 'unique:cuisines,name']
        ]);
        $this->service->create($validated);
        return redirect()->route('cuisines.index')->with('success', 'Dodano kuchnię.');
    }

    public function edit(Cuisine $cuisine)
    {
        return view('cuisines.edit', compact('cuisine'));
    }

    public function update(Request $request, Cuisine $cuisine)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:64', 'unique:cuisines,name,' . $cuisine->id]
        ]);
        $this->service->update($cuisine, $validated);
        return redirect()->route('cuisines.index')->with('success', 'Zmieniono kuchnię.');
    }

    public function destroy(Cuisine $cuisine)
    {
        $this->service->delete($cuisine);
        return redirect()->route('cuisines.index')->with('success', 'Usunięto kuchnię.');
    }
}
