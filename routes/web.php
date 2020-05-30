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
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('{path}', 'WelcomeController@index')->where('path','([A-z\d\-\/_.]+)?');
