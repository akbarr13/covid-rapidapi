<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProjectController;
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

Route::get('/', [ProjectController::class, 'main'])->name('main');
Route::post('/refresh-data', [ProjectController::class, 'refresh']);
Route::get('/search', [ProjectController::class, 'search']);
Route::get('/movie', [MovieController::class, 'index']);
