<?php


namespace App\Traits;


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
}