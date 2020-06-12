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




//get city
Route::get('/all/city', 'WelcomeController@city');
Route::get('/get/nhood/{id}', 'WelcomeController@nhood');


Auth::routes();
Route::group(['middleware'=>['auth']], function(){
    Route::post('/favorite/{id}/add','FavoriteController@add');
    Route::get('/user/product/myads','User\UserProductController@myAds');
    Route::get('/user/favorite/product','User\UserProductController@myfav');
    Route::put('/user/contact/status','User\UserController@contact_status');
    Route::put('/user/deactivate/account','User\UserController@deactivateAccount');

    //profile update
    Route::put('/update/profile', 'User\UserController@updateProfile');
    Route::get('/get/login/user', 'User\UserController@myProfile');

    //get subcategory for create ads controller
    Route::get('/create/ads/subcategory/{slug}', 'HomeController@subcategory');
    Route::get('/other/sub/{slug}', 'HomeController@otherSub');

    //product resource controller
    Route::resource('/user/add/product', 'User\ProductController');

});
Route::get('/home', 'HomeController@index')->name('home');

Route::get('{path}', 'WelcomeController@index')->where('path','([A-z\d\-\/_.]+)?');
