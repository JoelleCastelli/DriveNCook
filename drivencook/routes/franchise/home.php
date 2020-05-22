<?php

Route::get('/franchise/login', [
    'as' => 'franchise.login',
    'uses' => 'Franchise\AuthController@loginForm'
]);

Route::post('/franchise/login', [
    'as' => 'franchise.login_submit',
    'uses' => 'Franchise\AuthController@processLoginForm'
]);

Route::get('/franchise/registration/', [
    'as' => 'franchise.complete_registration',
    'uses' => 'Franchise\AuthController@complete_registration'
]);
Route::post('/franchise/registration/', [
    'as' => 'franchise.complete_registration_submit',
    'uses' => 'Franchise\AuthController@complete_registration_submit'
]);
Route::post('/franchise/registration/email', [
    'as' => 'franchise.complete_registration_email',
    'uses' => 'Franchise\AuthController@complete_registration_email'
]);

Route::get('/franchise/logout', [
    'as' => 'franchise.logout',
    'uses' => 'Franchise\AuthController@logout'
]);

Route::get('/franchise', [
    'as' => 'franchise.dashboard',
    'uses' => 'Franchise\AccountController@dashboard'
]);

Route::get('/franchise/account', [
    'as' => 'franchise.update_account',
    'uses' => 'Franchise\AccountController@update_account'
]);

Route::post('/franchise/account', [
    'as' => 'franchise.update_account_submit',
    'uses' => 'Franchise\AccountController@update_account_submit'
]);

Route::post('/franchise/account/password', [
    'as' => 'franchise.update_password',
    'uses' => 'Franchise\AccountController@update_password'
]);
