<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealType extends Model
{
    protected $table = 'meal_types';
    protected $fillable = ['name'];
}
