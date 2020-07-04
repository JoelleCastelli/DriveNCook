<?php

Route::get('/corporate/client', [
    'as' => 'client_list',
    'uses' => 'Corporate\ClientController@client_list'
]);

Route::get('/corporate/client/view/{id}', [
    'as' => 'client_view',
    'uses' => 'Corporate\ClientController@view_client'
]);

Route::get('/corporate/client/update/{id}', [
    'as' => 'client_update',
    'uses' => 'Corporate\ClientController@update_client'
]);

Route::post('/corporate/client/update/', [
    'as' => 'client_update_submit',
    'uses' => 'Corporate\ClientController@update_client_submit'
]);
Route::post('/corporate/client/password/', [
    'as' => 'client_update_password',
    'uses' => 'Corporate\ClientController@client_update_password'
]);

Route::get('/corporate/client/create/', [
    'as' => 'client_create',
    'uses' => 'Corporate\ClientController@add_client'
]);

Route::post('/corporate/client/newsletters/', [
    'as' => 'send_client_newsletters',
    'uses' => 'Corporate\ClientController@send_newsletter'
]);

Route::post('/corporate/client/newsletters/user', [
    'as' => 'send_client_newsletters_unique',
    'uses' => 'Corporate\ClientController@send_newsletter_unique'
]);

Route::post('/corporate/client/create/', [
    'as' => 'client_create_submit',
    'uses' => 'Corporate\ClientController@add_client_submit'
]);

Route::delete('/corporate/client/delete/{id}', [
    'as' => 'client_delete',
    'uses' => 'Corporate\ClientController@delete_client'
]);
