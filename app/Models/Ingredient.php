<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    //relacje:
    public function recipes()
    {
        //wiele do wielu
        return $this->belongsToMany(Recipe::class, 'recipe_ingredient')
        ->withPivot('amount');
    }

    //żeby CRUD działał pozwolenie na dodanie danych
    protected $fillable = ['name', 'unit', 'kcal_per_100g'];
}
