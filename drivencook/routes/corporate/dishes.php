<?php

Route::post('/corporate/dish_update_submit', [
    'as' => 'dish_update_submit',
    'uses' => 'Corporate\DishController@dish_update_submit'
]);

Route::post('/corporate/dish_creation_submit', [
    'as' => 'dish_creation_submit',
    'uses' => 'Corporate\DishController@dish_creation_submit'
]);

Route::delete('/corporate/dish_delete/{id}', [
    'as' => 'dish_delete',
    'uses' => 'Corporate\DishController@dish_delete'
]);