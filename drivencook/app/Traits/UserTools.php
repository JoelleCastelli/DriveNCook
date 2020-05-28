<?php


namespace App\Traits;


use App\Models\FranchiseObligation;
use App\Models\Invoice;
use App\Models\Pseudo;
use App\Models\PurchaseOrder;
use App\Models\Truck;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

trait UserTools
{
    public function update_user_password($id, $new_password)
    {
        User::find($id)->update([
            'password' => hash('sha256', $new_password)
        ]);
    }

    public function delete_user($id)
    {
        User::find($id)->delete();
    }

    public function get_connected_user()
    {
        if (auth()->guest()) {
            return null;
        }
        return auth()->user()->toArray();
    }

    public function does_have_assigned_truck($user_id): bool
    {
        $truck = Truck::with('location')
            ->where('user_id', $user_id)
            ->count();
        return $truck == 1;
    }

    public function get_current_obligation(){
        return FranchiseObligation::all()->sortByDesc('id')->first()->toArray();
    }

    public function create_invoice_reference($prefix, $franchisee_id, $invoice_id){
        $reference_start = $prefix.'-'.$franchisee_id.'-';
        $column_type = DB::select(DB::raw("SHOW COLUMNS FROM invoice WHERE Field = 'reference'"))[0]->Type;
        $column_length = substr(ltrim($column_type, 'varchar('), 0, -1);
        $pad_length = $column_length - strlen($reference_start);
        $reference = $reference_start.str_pad($invoice_id, $pad_length, "0", STR_PAD_LEFT);
        Invoice::where('id', $invoice_id)->update(['reference' => $reference]);
        return $reference;
    }

    public function generate_first_invoice($franchisee_id){
        $current_obligation = $this->get_current_obligation();
        $invoice = ['amount' => $current_obligation['entrance_fee'],
                    'date_emitted' => date("Y-m-d"),
                    'monthly_fee' => 0,
                    'initial_fee' => 1,
                    'user_id' => $franchisee_id];
        $invoice = Invoice::create($invoice);
        $reference = $this->create_invoice_reference('IF', $franchisee_id, $invoice['id']);
        $this->save_franchisee_invoice_pdf($invoice['id'], $reference);
    }

    public function franchisee_invoice_pdf($id) {
        $purchase_order = [];
        $invoice = Invoice::with('user')->where('id', $id)->first()->toArray();
        $pseudo = Pseudo::where('id', $invoice['user']['pseudo_id'])->first();
        if (!empty($pseudo))
            $pseudo->toArray();
        if ($invoice['purchase_order_id']) {
            $purchase_order = PurchaseOrder::with('purchased_dishes')
                                ->where('id', $invoice['purchase_order_id'])
                                ->first()->toArray();
        }

        return $pdf = PDF::loadView('franchisee_invoice', ['invoice' => $invoice,
                                                           'pseudo' => $pseudo,
                                                           'purchase_order' => $purchase_order]);
    }

    public function stream_franchisee_invoice_pdf($id) {
        $pdf = $this->franchisee_invoice_pdf($id);
        return $pdf->stream();
    }

    public function save_franchisee_invoice_pdf($id, $reference) {
        $pdf = $this->franchisee_invoice_pdf($id);
        if (strpos($reference, 'IF') !== FALSE) {
            $path = resource_path('invoices/franchisee_initial_fee/');
        } elseif (strpos($reference, 'MF') !== FALSE) {
            $path = resource_path('invoices/franchisee_monthly_fee/');
        } else if (strpos($reference, 'RS') !== FALSE) {
            $path = resource_path('invoices/franchisee_restock/');
        }

        return $pdf->save($path . '/' . $reference.'.pdf');
    }

}