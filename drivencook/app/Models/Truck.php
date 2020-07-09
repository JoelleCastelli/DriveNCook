<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Truck
 *
 * @property int $id
 * @property string|null $brand
 * @property string|null $model
 * @property int|null $functional
 * @property string|null $purchase_date
 * @property string|null $license_plate
 * @property string|null $registration_document
 * @property string|null $insurance_number
 * @property string|null $fuel_type
 * @property string|null $chassis_number
 * @property string|null $engine_number
 * @property int|null $horsepower
 * @property int|null $weight_empty
 * @property int|null $payload
 * @property string|null $general_state
 * @property int|null $user_id
 * @property int $location_id
 * @property string|null $location_date_start
 * @property string|null $location_date_end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Breakdown[] $breakdowns
 * @property-read int|null $breakdowns_count
 * @property-read \App\Models\SafetyInspection|null $last_safety_inspection
 * @property-read \App\Models\Location $location
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SafetyInspection[] $safety_inspection
 * @property-read int|null $safety_inspection_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereChassisNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereEngineNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereFuelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereFunctional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereGeneralState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereHorsepower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereInsuranceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereLicensePlate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereLocationDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereLocationDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck wherePurchaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereRegistrationDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Truck whereWeightEmpty($value)
 * @mixin \Eloquent
 */
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

    public function user_with_stocks()
    {
        return $this->belongsTo(User::class, 'user_id')
            ->with('pseudo')
            ->withCount('stocks')
            ->with('stocks')
            ->having('stocks_count', '>', 0);
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
