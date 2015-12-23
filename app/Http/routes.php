<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    # if (Auth::check()) return 'Welcome back, ' . Auth::user()->username;

    // dd(["Hi", Auth::check(), Auth::user()]);

    # return 'Hi guest. ' . link_to('login', 'Login with GitHub!');
    return view('welcome');
});

Route::get('/complete/github', 'AuthController@login');
Route::get('/login/github', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');

Route::get('/profile', 'UserController@profile');
Route::get('/profile/register', 'PaymentController@welcome');

Route::get('/profile/register/{tier}', 'PaymentController@tierSelect');
Route::post('/profile/register/free/confirm', 'PaymentController@confirmFree');
Route::get('/profile/register/{tier}/howtopay', 'PaymentController@selectPayment');
Route::get('/profile/register-done', 'PaymentController@confirmTier');
Route::get('/profile/register/_callback/{merchant}', 'PaymentController@merchantCallback');

