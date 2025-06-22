<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuisine extends Model
{
    //tabela jest robiona w poszczególnych migracjach, żeby ją utworzyć, po sprawdzeniu danych w .env, wystarczy dać = php artisan migrate
    protected $fillable = ['name'];
}
