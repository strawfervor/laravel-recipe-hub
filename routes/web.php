<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CuisineController;
use App\Http\Controllers\MealTypeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;

Route::get('/', [HomeController::class, 'home'])->name('home');

//auth:
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


//potem żeby coś było tylko dla zalogowanych dajemy ->middleware('auth') i bedzie sprawdzać czy user zalogowany
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

//składniki, używamy resource bo standardowe nazwy są użyte w kontrolerze przez wygenerowanie, to nie trzeba pisać wszystkiego osobno.:
Route::resource('ingredients', IngredientController::class)->middleware('auth');
Route::resource('cuisines', CuisineController::class)->middleware('auth');
Route::resource('meal-types', MealTypeController::class)->middleware('auth');

//publiczne trasy przed resource, zeby nie wymagały auth
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
//reszta resource z except na powyższe
Route::resource('recipes', RecipeController::class)
    ->except(['index', 'show'])
    ->middleware('auth');

//ocenianie i recenze tylko dowanie:
Route::post('/recipes/{recipe}/review', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');
Route::get('/reviews', [ReviewController::class, 'index'])->middleware('auth')->name('reviews.index');
Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->middleware('auth')->name('reviews.destroy');

//lubienie
Route::post('recipes/{recipe}/favorite', [FavoriteController::class, 'toggle'])->middleware('auth')->name('recipes.favorite');

//ulubione przepisy:
Route::get('/favorites', [FavoriteController::class, 'index'])->middleware('auth')->name('favorites.index');
