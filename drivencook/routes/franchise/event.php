<?php

Route::get('/franchise/event', [
    'as' => 'franchise.event_list',
    'uses' => 'Franchise\EventController@event_list'
]);

Route::get('/franchise/event/view/{event_id}', [
    'as' => 'franchise.event_view',
    'uses' => 'Franchise\EventController@event_view'
]);
