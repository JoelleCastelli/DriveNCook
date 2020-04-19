<?php


namespace App\Models;


class SafetyInspection extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'safety_inspection';

    protected $fillable = [
        'date', 'truck_age', 'truck_mileage', 'replaced_parts', 'drained_fluids', 'truck'
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck');
    }
    
}