<?php

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

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('admin/recipes', 'Admin\\RecipesController');
Route::resource('admin/ingradients', 'Admin\\IngradientsController');

Route::get('admin/recipes/{id}/delete-ingradient', 'Admin\\RecipesController@deleteIngradient');