<?php

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    //  主页
    Route::get('/', function()
    {
        return view('welcome');
    });
    Route::get('/project', 'ProjectController@index');
    Route::get('/project/{id}', 'ProjectController@show');
    Route::post('/project/{id}', 'ProjectController@leave');
    Route::post('/toFocusProject','ProjectController@toFocus');
    Route::get('/projectFocus', 'ProjectController@myFocusProject');

    Route::get('/partner', 'PartnerController@index');
    Route::get('/partner/{id}', 'PartnerController@show');
    Route::post('/toFocusProject','PartnerController@toFocus');
    Route::get('/partnerFocus', 'PartnerController@myFocusPartner');

    Route::get('/myProject','ProjectController@myShow');
    Route::get('/myProject/edit','ProjectController@myEdit');
    Route::post('/myProject/edit','ProjectController@update');

    Route::get('/profile','ProfileController@show');
    Route::get('/profile/edit','ProfileController@edit');
    Route::post('/profile/edit','ProfileController@update');

    Route::get('/setting','SettingController@show');
    Route::get('/setting/edit','SettingController@edit');
    Route::post('/setting/edit','SettingController@update');
});
