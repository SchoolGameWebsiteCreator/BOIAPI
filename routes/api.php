<?php

Route::group(['prefix' => 'v1'], function () {
    Route::get('/', [
        'uses' => 'Api\IndexController@index',
        'as' => 'api.index'
    ]);
    Route::get('{resource}/{id}', [
        'uses' => 'Api\ResourceController@showResource',
        'as' => 'api.resource.show'
    ]);
    Route::get('{resource}', [
        'uses' => 'Api\ResourceController@listResource',
        'as' => 'api.resource.list'
    ]);
});
