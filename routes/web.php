<?php

use App\Http\Controllers\QueryBuilderController;
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
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('videos', App\Http\Controllers\VideosController::class);

Route::get('filtros', [QueryBuilderController::class, 'filtros'])->name('query.builder.filtros');
Route::get('pruebas', [QueryBuilderController::class, 'pruebas'])->name('query.builder');
Route::get('insert', [QueryBuilderController::class, 'insert'])->name('query.builder.insert');
Route::get('update', [QueryBuilderController::class, 'update'])->name('query.builder.update');
Route::get('delete', [QueryBuilderController::class, 'delete'])->name('query.builder.delete');
