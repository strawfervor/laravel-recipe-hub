<?php

namespace App\Services;

use App\Models\Ingredient;

class IngredientService
{
    public function getAll($q = null)
    {
        return Ingredient::when($q, fn($query) =>
            $query->where('name', 'like', "%$q%")
        )->orderBy('name')->paginate(10);
    }

    public function create(array $data)
    {
        return Ingredient::create($data);
    }

    public function update(Ingredient $ingredient, array $data)
    {
        return $ingredient->update($data);
    }

    public function delete(Ingredient $ingredient)
    {
        return $ingredient->delete();
    }
}
