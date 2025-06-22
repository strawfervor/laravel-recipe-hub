<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['title', 'short_description', 'instructions', 'image_url', 'user_id', 'cuisine_id', 'meal_type_id', 'difficulty', 'is_active'];
    //robienie tabelki w migracji: https://laravel.com/docs/12.x/migrations#creating-tables

    //php artisan make:model nazwa -m

    //relacje
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //wiele do wielu
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient')
            ->withPivot('amount'); //withPivot pozwala pobrać pola z tabeli z relacji
    }
    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }
    public function mealType()
    {
        return $this->belongsTo(MealType::class, 'meal_type_id');
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
