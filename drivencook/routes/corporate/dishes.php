<?php

Route::post('/corporate/dish_update_submit', [
    'as' => 'dish_update_submit',
    'uses' => 'Corporate\DishController@dish_update_submit'
]);