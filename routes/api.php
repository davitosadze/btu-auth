<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post("/register", "Api\UserController@register")->name('register');
Route::post("/login", "Api\UserController@login")->name('login');

Route::group(["middleware" => ['auth:sanctum']], function() {
    Route::get('/profile', "Api\UserController@profile")->name('profile');
    Route::post('/logout', "Api\UserController@logout")->name('logout');
});
