<?php

Route::get('/corporate/login', [
    'as' => 'corporate_login',
    'uses' => 'Corporate\CorporateAuthController@loginForm'
]);

Route::post('/corporate/login', [
    'as' => 'corporate_login',
    'uses' => 'Corporate\CorporateAuthController@processLoginForm'
]);

Route::get('/corporate/logout', [
    'as' => 'corporate_logout',
    'uses' => 'Corporate\CorporateAuthController@logout'
]);

Route::get('/corporate', [
    'as' => 'corporate_dashboard',
    'uses' => 'Corporate\AccountController@dashboard'
]);

Route::get('/corporate/account', [
    'as' => 'corporate.update_account',
    'uses' => 'Corporate\AccountController@update_account'
]);

Route::post('/corporate/account', [
    'as' => 'corporate.update_account_submit',
    'uses' => 'Corporate\AccountController@update_account_submit'
]);

Route::post('/corporate/account/password', [
    'as' => 'corporate.update_password',
    'uses' => 'Corporate\AccountController@update_password'
]);
