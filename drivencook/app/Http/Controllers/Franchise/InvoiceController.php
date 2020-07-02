<?php

namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Models\FranchiseObligation;
use App\Models\Invoice;
use App\Traits\UserTools;
use DateTime;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use UserTools;

    public function invoices_list() {
        $franchisee_id = $this->get_connected_user()['id'];
        $invoices = Invoice::with('user')->where('user_id', $franchisee_id)->get()->toArray();
        $current_obligation = $this->get_current_obligation();
        $current_obligation['date_updated'] = DateTime::createFromFormat("Y-m-d", $current_obligation['date_updated'])->format('d/m/Y');
        return view('franchise.invoices_list')->with('invoices', $invoices)->with('current_obligation', $current_obligation);
    }

    public function stream_invoice_pdf($id) {
        return $this->stream_invoice_pdf($id);
    }
}
