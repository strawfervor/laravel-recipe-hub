<?php

namespace App\Services;

use App\Models\MealType;

class MealTypeService
{
    public function getAll(?string $q = null, int $perPage = 10)
    {
        return MealType::when(
            $q,
            fn($query) => $query->where('name', 'like', "%$q%")
        )
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data)
    {
        return MealType::create($data);
    }

    public function update(MealType $mealType, array $data)
    {
        $mealType->update($data);
        return $mealType;
    }

    public function delete(MealType $mealType)
    {
        return $mealType->delete();
    }
}
