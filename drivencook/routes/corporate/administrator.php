<?php

Route::get('/corporate/administrator/user_list', [
    'as' => 'user_list',
    'uses' => 'Corporate\AdministratorController@user_list'
]);

Route::get('/corporate/administrator/user_view', [
    'as' => 'user_view',
    'uses' => 'Corporate\AdministratorController@user_view'
]);