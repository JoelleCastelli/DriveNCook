<?php

Route::get('/corporate/dish_list', [
    'as' => 'dish_list',
    'uses' => 'Corporate\DishController@dish_list'
]);

Route::get('/corporate/dish_view/{id}', [
    'as' => 'dish_view',
    'uses' => 'Corporate\DishController@dish_view'
]);

Route::get('/corporate/dish_update/{id}', [
    'as' => 'dish_update',
    'uses' => 'Corporate\DishController@dish_update'
]);

Route::post('/corporate/dish_update_submit', [
    'as' => 'dish_update_submit',
    'uses' => 'Corporate\DishController@dish_update_submit'
]);

Route::delete('/corporate/dish_delete/{id}', [
    'as' => 'dish_delete',
    'uses' => 'Corporate\DishController@dish_delete'
]);