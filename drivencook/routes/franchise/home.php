<?php

Route::get('/franchise/login', [
    'as' => 'franchise.login',
    'uses' => 'Franchise\AuthController@loginForm'
]);

Route::post('/franchise/login', [
    'as' => 'franchise.login_submit',
    'uses' => 'Franchise\AuthController@processLoginForm'
]);

Route::get('/franchise/logout', [
    'as' => 'franchise.logout',
    'uses' => 'Franchise\AuthController@logout'
]);

Route::get('/franchise', [
    'as' => 'franchise.dashboard',
    'uses' => 'Franchise\AccountController@dashboard'
]);