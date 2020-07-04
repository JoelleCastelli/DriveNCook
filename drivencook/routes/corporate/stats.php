<?php

Route::get('/corporate/statistics', [
    'as' => 'corporate_statistics',
    'uses' => 'Corporate\FranchiseeController@all_franchisees_sales_stats'
]);