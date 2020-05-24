<?php

Route::get('/franchise/invoices', [
    'as' => 'franchise.invoices_list',
    'uses' => 'Franchise\InvoiceController@invoices_list'
]);

Route::get('/franchise/invoice/{id}', [
    'as' => 'franchise.invoice_pdf',
    'uses' => 'Franchise\InvoiceController@invoice_pdf'
]);