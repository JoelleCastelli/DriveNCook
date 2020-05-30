<?php

Route::get('/franchise/revenues_stats', [
    'as' => 'franchise.revenues_stats',
    'uses' => 'Franchise\RevenuesStatsController@view_revenues_stats'
]);

Route::post('/franchise/franchisee_sales_history_pdf', [
    'as' => 'sales_history_pdf',
    'uses' => 'Franchise\RevenuesStatsController@franchisee_sales_history_pdf'
]);

Route::get('chart-line', 'RevenuesStatsController@chartLine');

Route::get('chart-line-ajax', 'RevenuesStatsController@chartLineAjax');