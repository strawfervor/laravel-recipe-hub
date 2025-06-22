<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'recipe_id'];
    public $timestamps = true;

    public function recipe()
    {
        return $this->belongsTo(\App\Models\Recipe::class);
    }
}
