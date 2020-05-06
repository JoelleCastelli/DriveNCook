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

Route::get('/corporate/client/create/', [
    'as' => 'client_create',
    'uses' => 'Corporate\ClientController@add_client'
]);

Route::post('/corporate/client/create/', [
    'as' => 'client_create_submit',
    'uses' => 'Corporate\ClientController@add_client_submit'
]);

Route::delete('/corporate/client/delete/{id}', [
    'as' => 'client_delete',
    'uses' => 'Corporate\ClientController@delete_client'
]);
