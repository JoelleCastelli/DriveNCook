<?php


namespace App\Models;


class Breakdown extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'breakdown';

    protected $fillable = [
        'type', 'description', 'cost', 'date', 'status', 'truck_id'
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck_id');
    }
}