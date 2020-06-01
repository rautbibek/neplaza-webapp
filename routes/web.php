<?php

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

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/menu/category', 'CategoryController@category');
Route::get('/menu/subCategory', 'CategoryController@subCategory');
Route::get('/front/all/product', 'ProductController@allProduct');
Route::get('/front/category/product/{slug}', 'CategoryController@CategoryProduct');
Route::get('/front/featured/product', 'ProductController@premium');

Auth::routes();
Route::group(['middleware'=>['auth']], function(){
    Route::post('/favorite/{id}/add','FavoriteController@add');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::get('{path}', 'WelcomeController@index')->where('path','([A-z\d\-\/_.]+)?');
