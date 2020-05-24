<?php

namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function invoices_list() {
        // récupérer le mail en session
        return view('franchise.invoices_list');
    }

}
