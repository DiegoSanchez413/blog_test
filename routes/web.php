<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
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


Route::get('/register', [UserController::class, 'register'])->name('register');
Route::get('/validate-login', [UserController::class, 'validateLogin'])->name('validate.login');

Route::get('/', [UserController::class, 'login'])->name('login');

Route::group(['prefix' => 'user'], function () {
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::get('/home', [UserController::class, 'home'])->name('home');
});

Route::group(['prefix' => 'article'], function () {
    Route::post('/store', [ArticleController::class, 'store'])->name('article.store');
    Route::get('/list', [ArticleController::class, 'list'])->name('article.list');
    Route::get('/list/{id}', [ArticleController::class, 'getArticle'])->name('article.list.id');
    Route::put('/update', [ArticleController::class, 'update'])->name('article.update');
    Route::delete('/delete/{id}', [ArticleController::class, 'delete'])->name('article.delete');
});
