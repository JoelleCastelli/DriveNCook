<?php

Route::get('/client/registration', [
    'as' => 'registration',
    'uses' => 'Client\AccountController@registration'
]);

Route::post('/client/registration_submit', [
    'as' => 'registration_submit',
    'uses' => 'Client\AccountController@registration_submit'
]);

Route::get('/client', [
    'as' => 'client_dashboard',
    'uses' => 'Client\AccountController@dashboard'
]);