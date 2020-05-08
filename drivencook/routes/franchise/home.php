<?php

Route::get('/franchise/login', [
    'as' => 'franchise.login',
    'uses' => 'Franchise\AccountController@loginForm'
]);

Route::post('/franchise/login', [
    'as' => 'franchise.login_submit',
    'uses' => 'Franchise\AccountController@processLoginForm'
]);

Route::get('/franchise/logout', [
    'as' => 'franchise.logout',
    'uses' => 'Franchise\AccountController@logout'
]);

Route::get('/franchise', [
    'as' => 'franchise.dashboard',
    'uses' => 'Franchise\AccountController@dashboard'
]);