<?php

use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/api', [APIController::class, 'getAPI']);
Route::get('/random-item', [APIController::class, 'randomItem']);
Route::get('/search-by-text/{text}', [APIController::class, 'searchByText']);

Route::get('/list-categories', [APIController::class, 'listCategories']);
Route::get('/search-by-category/{category}', [APIController::class, 'searchByCategory']);
