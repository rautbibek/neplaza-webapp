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
Route::get('/front/category/product/{slug}', 'CategoryController@categoryProduct');
Route::get('/front/scategory/product/{slug}', 'SubcategoryController@scategoryProduct');
Route::get('/front/scategory/filter/{slug}', 'SubcategoryController@subcategoryFilter');
Route::get('/front/featured/product', 'ProductController@premium');




//get city
Route::get('/all/city', 'WelcomeController@city');
Route::get('/get/nhood/{id}', 'WelcomeController@nhood');


Auth::routes();
Route::group(['middleware'=>['auth']], function(){
    //myads component
    Route::post('/favorite/{id}/add','FavoriteController@add');
    Route::get('/user/product/myads','User\UserProductController@myAds');
    Route::get('/user/favorite/product','User\UserProductController@myfav');

    Route::get('/user/product/deleted','User\UserProductController@deleted');
    Route::get('/user/product/featured','User\UserProductController@featured');
    Route::get('/user/product/urgent','User\UserProductController@urgent');
    Route::get('/user/product/sold','User\UserProductController@sold');
    



    Route::put('/user/contact/status','User\UserController@contact_status');
    Route::put('/user/deactivate/account','User\UserController@deactivateAccount');

    //profile update
    Route::put('/update/profile', 'User\UserController@updateProfile');
    Route::get('/get/login/user', 'User\UserController@myProfile');

    //get subcategory for create ads controller
    Route::get('/create/ads/subcategory/{slug}', 'HomeController@subcategory');
    Route::get('/other/sub/{slug}', 'HomeController@otherSub');

    //product resource controller
    Route::put('/resell/ad/{id}', 'User\ProductController@resell');
    Route::put('/restore/ad/{id}', 'User\ProductController@restore');
    Route::put('/sold/ad/{id}', 'User\ProductController@sold');
    Route::put('/trash/ad/{id}', 'User\ProductController@softDelete');
    Route::resource('/user/add/product', 'User\ProductController');
    Route::delete('/delete/image/{image_id}', 'User\ImageController@delete');
    Route::post('/save/image/{image_id}', 'User\ImageController@store');

});
Route::get('/home', 'HomeController@index')->name('home');

Route::get('{path}', 'WelcomeController@index')->where('path','([A-z\d\-\/_.]+)?');
