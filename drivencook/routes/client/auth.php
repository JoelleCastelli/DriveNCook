<?php

Route::get('/client/login', [
    'as' => 'client_login',
    'uses' => 'Client\AuthController@loginForm'
]);


Route::post('/client/login', [
    'as' => 'client_login',
    'uses' => 'Client\AuthController@processLoginForm'
]);

Route::get('/client/logout', [
    'as' => 'client_logout',
    'uses' => 'Client\AuthController@logout'
]);