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

Route::get('/profile/volunteer', [
    'middleware' => 'auth',
    'uses' => 'VolunteerController@welcome'
]);

Route::post('/profile/volunteer/join', [
    'middleware' => 'auth',
    'uses' => 'VolunteerController@join'
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

Route::post('/profile/register/handle/{merchant}', [
    'middlware' => 'auth',
    'uses' => 'PaymentController@merchantHandle'
]);

Route::get('/profile/register/_callback/{merchant}', [
    'middlware' => 'auth',
    'uses' => 'PaymentController@merchantCallback'
]);

Route::group(['middleware' => 'ghadmin'], function () {

    Route::get('/admin', 'Admin\AdminController@dashboard');
    Route::get('/admin/org-access', 'Admin\AdminController@orgRequests');
    Route::get('/admin/org-access/volunteers', 'Admin\AdminController@volunteerRequests');
    Route::post('/admin/org-access', 'Admin\AdminController@orgPost');
    Route::get('/admin/members', 'Admin\AdminController@listMembers');
    Route::get('/admin/transactions', 'Admin\AdminController@listTransactions');

});

