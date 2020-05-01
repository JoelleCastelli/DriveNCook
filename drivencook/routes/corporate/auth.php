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