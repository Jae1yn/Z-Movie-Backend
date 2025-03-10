<?php

Route::group(['namespace' => 'Test', 'prefix' => 'test'], function () {
    Route::get('list', 'TestController@list');
});
