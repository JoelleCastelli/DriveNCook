<?php

Route::get('/corporate/administrator/admin_list', [
    'as' => 'admin_list',
    'uses' => 'Corporate\AdministratorController@admin_list'
]);

Route::get('/corporate/administrator/admin_creation', [
    'as' => 'admin_creation',
    'uses' => 'Corporate\AdministratorController@admin_creation'
]);

Route::post('/corporate/administrator/admin_creation_submit', [
    'as' => 'admin_creation_submit',
    'uses' => 'Corporate\AdministratorController@admin_creation_submit'
]);