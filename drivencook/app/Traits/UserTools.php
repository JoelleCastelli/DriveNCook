<?php


namespace App\Traits;


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
}