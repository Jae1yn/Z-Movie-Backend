<?php

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::post('login', 'LoginController@login');

    Route::group(['middleware' => 'admin',], function () {
        Route::post('update', 'UserController@update');
        Route::post('changePassword', 'UserController@changePassword');
        Route::post('logout', 'LoginController@logout');
    });
});
