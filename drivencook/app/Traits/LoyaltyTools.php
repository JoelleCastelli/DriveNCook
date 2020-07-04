<?php


namespace App\Traits;

use App\Models\FidelityStep;
use App\Models\User;
use Session;

trait LoyaltyTools
{
    public function get_fidelity_steps() {

        $fidelityStep = FidelityStep::orderBy('step')
            ->get();

        if(!empty($fidelityStep)) {
            $fidelityStep = $fidelityStep->toArray();
        }

        return $fidelityStep;
    }

    public function put_loyalty_point_in_session($userId) {

        $user = User::whereKey($userId)
            ->first();

        $loyaltyPoint = 0;
        if(!empty($user)) {
            $loyaltyPoint = $user->loyalty_point;
        }

        Session::put('loyalty_point', $loyaltyPoint);
    }
}