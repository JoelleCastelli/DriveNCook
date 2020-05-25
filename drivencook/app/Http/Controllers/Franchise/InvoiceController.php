<?php

namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Traits\UserTools;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use UserTools;

    public function invoices_list() {
        $franchisee_id = $this->get_connected_user()['id'];
        $invoices = Invoice::with('user')->where('user_id', $franchisee_id)->get()->toArray();
        return view('franchise.invoices_list')->with('invoices', $invoices);
    }

    public function stream_invoice_pdf($id) {
        return $this->stream_franchisee_invoice_pdf($id);
    }
}
