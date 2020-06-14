<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'user_id', 'location_id', 'location_date_start', 'location_date_end',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @return BelongsTo
     * @var array
     */
    /*protected $hidden = [

    ];*/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->with('pseudo');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function breakdowns()
    {
        return $this->hasMany(Breakdown::class, 'truck_id');
    }

    public function safety_inspection()
    {
        return $this->hasMany(SafetyInspection::class, 'truck_id');
    }
    public function last_safety_inspection()
    {
        return $this->hasOne(SafetyInspection::class, 'truck_id')->orderByDesc('id');
    }
}
