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
        $invoice = ['amount' => $current_obligation['entrance_fee'], 'date_emitted' => date("Y-m-d"), 'status' => 'A payer', 'user_id' => $id];
        Invoice::create($invoice);
    }
}