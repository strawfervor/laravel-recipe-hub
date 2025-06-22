<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class HomeController extends Controller
{
    public function home()
{
    //w take można dać ile najnowszych przepisów ma wyświetlać
    $najnowszePrzepisy = Recipe::latest()->take(8)->get();
    return view('home.index', compact('najnowszePrzepisy'));
}
}
