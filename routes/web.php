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
Route::get('/seller/detail/{id}/{username}', 'WelcomeController@seller')->name('seller');
Route::get('/seller/{id}/ad', 'WelcomeController@sellerAd')->name('seller.ad');
//search products
Route::get('/ad/search', 'SearchController@search')->name('search');
Route::get('/searchResult', 'SearchController@searchResult')->name('/search/result');



///admin part

Route::prefix('admin')->group(function(){
    Route::get('/login', 'Auth\AdminLoginController@adminLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
});
Route::group(['as'=>'admin.','prefix'=>'admin','middleware'=>'auth:admin', 'namespace'=>'Admin'],function(){
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('/category', 'CategoryController')->except('show','edit');
    Route::resource('/subcategory', 'SubcategoryController')->except('show','edit');
    Route::resource('/city', 'CityController')->except('show','edit');
    Route::resource('/neighbourhood', 'NeighbourhoodController')->except('create','edit','show');
    Route::resource('/brand', 'BrandController')->except('create','edit');
    Route::resource('/type', 'TypeController')->except('create','edit');
    Route::resource('/status', 'StatusController')->except('create','edit');
    Route::resource('/user', 'UserController')->except('edit');
    Route::resource('/product', 'ProductController')->except('edit');
});
//testing
Route::get('/check', 'WelcomeController@check')->name('check');

Route::get('/menu/category', 'CategoryController@category');
Route::get('/menu/subCategory', 'CategoryController@subCategory');
Route::get('/front/all/product', 'ProductController@allProduct');
Route::get('/front/category/product/{slug}', 'CategoryController@categoryProduct');
Route::get('/front/scategory/product/{slug}', 'SubcategoryController@scategoryProduct');
Route::get('/front/scategory/filter/{slug}', 'SubcategoryController@subcategoryFilter');
Route::get('/front/featured/product', 'ProductController@premium');
Route::get('/ad/comment/{id}','CommentController@getComment');
Route::get('/product/detail/{id}', 'ProductController@productDetail');


//login controller
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');


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

    //notification 
    Route::get('/get/notification','User\UserController@notification');
    Route::get('/markAsRead/{id}','User\UserController@read');
    Route::get('/read/notification','User\UserController@readNotification');

    //comment controller
    Route::post('/user/comment','User\CommentController@post');
    Route::post('/reply/ad/comment','User\CommentController@reply');
    Route::delete('/delete/comment/{id}','User\CommentController@commentDelete');


    Route::put('/user/contact/status','User\UserController@contact_status');
    Route::put('/user/deactivate/account','User\UserController@deactivateAccount');
    Route::put('/update/contact','User\UserController@updateContact');
    

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
