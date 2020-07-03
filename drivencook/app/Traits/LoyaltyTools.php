<?php


namespace App\Traits;


use App\Models\FidelityStep;

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
}