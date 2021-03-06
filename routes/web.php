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

/*Route::get('/', function() {
    return View::make('index'); // will return app/views/index.php
    //return view('unsupported_browser');
});*/

//Auth::routes();
// API ROUTES ==================================
Route::group(array('prefix' => 'api'), function() {

    // since we will be using this just for CRUD, we won't need create and edit
    // Angular will handle both of those forms
    // this ensures that a user can't access api/create or api/edit when there's nothing there
    Route::resource('comments', 'CommentController',
        array('only' => array('index', 'store', 'destroy')));

});



//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/verify', 'VerifyOAuthController@store')->name('verify');
Route::post('register','RegisterController@register')->name('register');
//Route::post('oauth/token','Auth\LoginController@login')->name('oauth/token');
Route::post('oauth/token', 'AccessTokenController@issueToken'); //customised route this override defauls laravel access token controller

/*Route::any('{catchall}', function() {
  //some code
})->where('catchall', '.*');
*/
//Auth::routes();
Route::post('auth/google', 'AuthController@google');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/skill/{skill}', 'SkillsController@getSkill');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/clear-config', function() {
    Artisan::call('config:cache');
    return "Config is cleared";
});


