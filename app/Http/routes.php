<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::match(['get', 'post'], '/aaa', function () {
////    return view('welcome');
//    echo 'hello';
//});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
Route::get('/', function()
{
    return view('components.body');
});

Route::get('/project', 'ProjectController@index');
Route::get('/project/{id}', 'ProjectController@show');

Route::get('/partner', 'PartnerController@index');

Route::get('/register', 'Auth\AuthController@index');
