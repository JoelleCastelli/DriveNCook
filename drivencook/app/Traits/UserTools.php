<?php


namespace App\Traits;


use App\Models\FranchiseObligation;
use App\Models\Invoice;
use App\Models\Truck;
use App\Models\User;
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

    public function create_invoice_reference($prefix, $franchisee_id, $invoice_id){
        $reference_start = $prefix.'-'.$franchisee_id.'-';
        $column_type = DB::select(DB::raw("SHOW COLUMNS FROM invoice WHERE Field = 'reference'"))[0]->Type;
        $column_length = substr(ltrim($column_type, 'varchar('), 0, -1);
        $pad_length = $column_length - strlen($reference_start);
        $reference = $reference_start.str_pad($invoice_id, $pad_length, "0", STR_PAD_LEFT);
        Invoice::where('id', $invoice_id)->update(['reference' => $reference]);
    }

    public function generate_first_invoice($franchisee_id){
        $current_obligation = FranchiseObligation::all()->sortByDesc('id')->first()->toArray();
        $invoice = ['amount' => $current_obligation['entrance_fee'],
                    'date_emitted' => date("Y-m-d"),
                    'status' => 'A payer',
                    'monthly_fee' => 0,
                    'initial_fee' => 1,
                    'user_id' => $franchisee_id];
        $invoice = Invoice::create($invoice);
        $this->create_invoice_reference('IF', $franchisee_id, $invoice['id']);
    }
}