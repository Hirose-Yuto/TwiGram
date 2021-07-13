<?php

use Illuminate\Support\Facades\Auth;
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

// Home画面
// Route::get('/test/{twig_id}', "App\Http\Controllers\TwigController@whotwig");

// login, register, logout予約済み
Auth::routes();

// Home画面
Route::get('/', "App\Http\Controllers\HomeController@timeline");

// Twig
Route::post('/', "App\Http\Controllers\HomeController@twig")->middleware("auth");
// Delete Twig
Route::post('/twig/delete', "App\Http\Controllers\TwigController@deleteTwig")->middleware("auth");
// Twig表示
Route::get('/twig/{twig_id}', "App\Http\Controllers\TwigController@display");

// Settings
Route::get('/settings', "App\Http\Controllers\SettingsController@settings")->middleware("auth");

//Edit Profile
Route::get('/edit-profile', "App\Http\Controllers\ProfileController@editProfilePage")->middleware("auth");
Route::post('/edit-profile', "App\Http\Controllers\ProfileController@editProfile")->middleware("auth");

// Follow
Route::post('/follow', "App\Http\Controllers\FollowFollowedRelationshipController@follow")->middleware("auth");
// Unfollow
Route::post('/un-follow', "App\Http\Controllers\FollowFollowedRelationshipController@unFollow")->middleware("auth");

// Reply
Route::post("/twig/reply", "App\Http\Controllers\TwigController@reply")->middleware("auth");
// Retwig
Route::post("/twig/retwig", "App\Http\Controllers\TwigController@retwig")->middleware("auth");
// Like
Route::post("/twig/like", "App\Http\Controllers\UsersLikesController@like")->middleware("auth");

Route::get('/hello',function(){
    return '<html><body><h1>hello world</h1></body></html>';
})->middleware("test");


// プロフィール画面
Route::get('/{screen_name}', "App\Http\Controllers\ProfileController@main");
Route::get('/{screen_name}/{mode}', "App\Http\Controllers\ProfileController@main");


