<?php


namespace App\Traits;


use App\Models\Truck;

trait TruckTools
{
    public function get_franchises_truck($franchise_id)
    {
        $truck = Truck::with('location')
            ->with('breakdowns')
            ->with('last_safety_inspection')
            ->with('safety_inspection')
            ->where('user_id', $franchise_id)
            ->first();
        if ($truck != null) {
            $truck = $truck->toArray();
        }
        return $truck;
    }

    public function get_truck_with_franchisee_by_truck_id($truck_id) {
        $truck = Truck::with('user')
            ->where('id', $truck_id)
            ->first();
        if ($truck != null) {
            $truck = $truck->toArray();
        }
        return $truck;
    }

    public function get_truck_with_location_only($truck_id)
    {
        $truck = Truck::with('location')
            ->whereKey($truck_id)
            ->first();

        if ($truck != null) {
            $truck = $truck->toArray();
        }
        return $truck;
    }
}