<?php

namespace App\Services;

use App\Models\Cuisine;

class CuisineService
{
    //pytajnik przed string, bo moze być null i intellisense tego nie lubi i rzuca error
    public function getAll(?string $q = null, int $perPage = 10)
    {
        return Cuisine::when(
            $q,
            fn($query) => $query->where('name', 'like', "%$q%")
        )
        ->orderBy('name')
        ->paginate($perPage)
        ->withQueryString();
    }

    public function create(array $data)
    {
        return Cuisine::create($data);
    }

    public function update(Cuisine $cuisine, array $data)
    {
        $cuisine->update($data);
        return $cuisine;
    }

    public function delete(Cuisine $cuisine)
    {
        return $cuisine->delete();
    }
}
