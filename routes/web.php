<?php

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

Route::get('/', 'IndexController@index');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// facebook socialite
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

// google socialite
Route::get('login/google', 'Auth\LoginController@redirectToProviderGoogle');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallbackGoogle');

// twitter socialite
Route::get('login/twitter', 'Auth\LoginController@redirectToProviderTwitter');
Route::get('login/twitter/callback', 'Auth\LoginController@handleProviderCallbackTwitter');

// linkedin socialite
Route::get('login/linkedin', 'Auth\LoginController@redirectToProviderLinkedin');
Route::get('login/linkedin/callback', 'Auth\LoginController@handleProviderCallbackLinkedin');


Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
