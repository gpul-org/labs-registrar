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
Route::get('/auth/login', 'AuthController@login');
Route::get('/login/github', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');

Route::get('/profile', [
    'middleware' => 'auth',
    'uses' => 'UserController@profile'
]);

Route::get('/profile/register', [
    'middleware' => 'auth',
    'uses' => 'PaymentController@welcome'
]);

Route::get('/profile/register/as/{tier}', [
    'middleware' => 'auth',
    'uses' => 'PaymentController@tierSelect'
]);

Route::post('/profile/register/as/free/confirm', [
    'middleware' => 'auth',
    'uses' => 'PaymentController@confirmFree'
]);

Route::get('/profile/register/as/{tier}/howtopay', [
    'middleware' => 'auth',
    'uses' => 'PaymentController@selectPayment'
]);

Route::get('/profile/register/done', [
    'middleware' => 'auth',
    'uses' => 'PaymentController@confirmTier'
]);

Route::get('/profile/transactions', [
    'middleware' => 'auth',
    'uses' => 'PaymentController@logs'
]);

Route::get('/profile/register/_callback/{merchant}', [
    'middlware' => 'auth',
    'uses' => 'PaymentController@merchantCallback'
]);

Route::get('/admin', [
    'middleware' => 'auth',
    'uses' => 'Admin\AdminController@dashboard'
]);

Route::get('/admin/org-access', [
    'middleware' => 'auth',
    'uses' => 'Admin\AdminController@orgRequests'
]);

Route::post('/admin/org-access', [
    'middleware' => 'auth',
    'uses' => 'Admin\AdminController@orgPost'
]);

Route::get('/admin/members', [
    'middleware' => 'auth',
    'uses' => 'Admin\AdminController@listMembers'
]);

Route::get('/admin/transactions', [
    'middleware' => 'auth',
    'uses' => 'Admin\AdminController@listTransactions'
]);


