<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $table = 'truck';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand', 'model', 'functional', 'purchase_date', 'license_plate', 'registration_document', 'insurance_number',
        'fuel_type', 'chassis_number', 'engine_number', 'horsepower', 'weight_empty', 'payload', 'general_state',
        'user', 'location', 'location_date_start', 'location_date_end',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
