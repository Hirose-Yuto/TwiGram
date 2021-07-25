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

// login, register, logout予約済み
Auth::routes();

Route::middleware("auth")->group(function () {
    // Home画面
    Route::get('/', "App\Http\Controllers\HomeController@timeline")->name("home");

    //ユーザ一覧
    Route::get("/users", function (){
        return view("users", ["users" => \App\Models\User::query()->get()]);}
    );

    // 検索
    Route::post('/search/{mode?}', "App\Http\Controllers\SearchController@search");

    // Twig
    Route::post('/', "App\Http\Controllers\HomeController@twig");
    // Reply
    Route::post("/twig/reply", "App\Http\Controllers\TwigController@reply");
    // Retwig
    Route::post("/twig/retwig", "App\Http\Controllers\TwigController@retwig");
    // Like
    Route::post("/twig/like", "App\Http\Controllers\UsersLikesController@like");

    // Delete Twig
    Route::post('/twig/delete', "App\Http\Controllers\TwigController@deleteTwig");
    // Twig表示
    Route::get('/twig/{twig_id}', "App\Http\Controllers\TwigController@display");

    // Settings
    Route::get('/settings', "App\Http\Controllers\SettingsController@settings")->name("settings");

    //Edit Profile
    Route::get('/edit-profile', "App\Http\Controllers\ProfileController@editProfilePage");
    Route::post('/edit-profile', "App\Http\Controllers\ProfileController@editProfile");

    // Follow
    Route::post('/follow', "App\Http\Controllers\FollowFollowedRelationshipController@follow");
    // Unfollow
    Route::post('/un-follow', "App\Http\Controllers\FollowFollowedRelationshipController@unFollow");

    // プロフィール画面
    Route::get('/{screen_name}', "App\Http\Controllers\ProfileController@main")->name("profile");
    Route::get('/{screen_name}/{mode}', "App\Http\Controllers\ProfileController@main");

});
