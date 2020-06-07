<?php

use App\Http\Middleware\AuthClient;

Route::get('/client/registration', [
    'as' => 'registration',
    'uses' => 'Client\AccountController@registration'
]);

Route::post('/client/registration_submit', [
    'as' => 'registration_submit',
    'uses' => 'Client\AccountController@registration_submit'
]);

Route::group(['middleware' => AuthClient::class], function() {
    Route::get('/client', [
        'as' => 'client_dashboard',
        'uses' => 'Client\AccountController@dashboard'
    ]);

    Route::get('/client/account', [
        'as' => 'client_account',
        'uses' => 'Client\AccountController@account'
    ]);

    Route::post('/client/update_account_submit', [
        'as' => 'client_update_account_submit',
        'uses' => 'Client\AccountController@update_account_submit'
    ]);

    Route::post('/client/update_account_password', [
        'as' => 'client_update_account_password',
        'uses' => 'Client\AccountController@update_account_password'
    ]);

    Route::get('/client/delete_account', [
        'as' => 'client_delete_account',
        'uses' => 'Client\AccountController@delete_account'
    ]);
});
