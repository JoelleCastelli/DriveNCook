<?php


namespace App\Traits;


use App\Models\FranchiseObligation;
use App\Models\Invoice;
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

    public function generate_first_invoice($id){
        $current_obligation = FranchiseObligation::all()->sortByDesc('id')->first()->toArray();
        $invoice = ['amount' => $current_obligation['entrance_fee'],
                    'date_emitted' => date("Y-m-d"),
                    'status' => 'A payer',
                    'monthly_fee' => 0,
                    'initial_fee' => 1,
                    'user_id' => $id];
        $invoice = Invoice::create($invoice);

        // Reference creation
        $reference_start = 'IF-'.$id.'-';
        $variable_type = DB::select(DB::raw("SHOW COLUMNS FROM invoice WHERE Field = 'reference'"))[0]->Type;
        $variable_length = substr(ltrim($variable_type, 'varchar('), 0, -1);
        $pad_length = $variable_length - strlen($reference_start);
        $reference = $reference_start.str_pad($invoice['id'], $pad_length, "0", STR_PAD_LEFT);
        Invoice::where('id', $invoice['id'])->update(['reference' => $reference]);
    }
}