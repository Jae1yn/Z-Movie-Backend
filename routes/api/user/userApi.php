<?php

Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {
    Route::post('login', 'LoginController@login');

    Route::group(['middleware' => 'login'], function () {
        Route::post('update', 'UserController@update');
        Route::post('changePassword', 'UserController@changePassword');
        Route::post('logout', 'LoginController@logout');
    });
});
