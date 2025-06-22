<?php

namespace App\Http\Controllers;


use App\Models\Cuisine;
use Illuminate\Http\Request;

class CuisineController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $cuisines = Cuisine::when(
            $q,
            fn($query) =>
            $query->where('name', 'like', "%$q%")
        )->orderBy('name')->paginate(10)->withQueryString();

        return view('cuisines.index', compact('cuisines', 'q'));
    }

    public function create()
    {
        return view('cuisines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:64', 'unique:cuisines,name']
        ]);
        Cuisine::create($request->only('name'));
        return redirect()->route('cuisines.index')->with('success', 'Dodano kuchnię.');
    }

    public function edit(Cuisine $cuisine)
    {
        return view('cuisines.edit', compact('cuisine'));
    }

    public function update(Request $request, Cuisine $cuisine)
    {
        $request->validate([
            'name' => ['required', 'max:64', 'unique:cuisines,name,' . $cuisine->id]
        ]);
        $cuisine->update($request->only('name'));
        return redirect()->route('cuisines.index')->with('success', 'Zmieniono kuchnię.');
    }

    public function destroy(Cuisine $cuisine)
    {
        $cuisine->delete();
        return redirect()->route('cuisines.index')->with('success', 'Usunięto kuchnię.');
    }
}
