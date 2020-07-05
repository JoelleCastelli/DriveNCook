<?php


namespace App\Models;


/**
 * App\Models\SafetyInspection
 *
 * @property int $id
 * @property string|null $date
 * @property int|null $truck_age
 * @property int|null $truck_mileage
 * @property string|null $replaced_parts
 * @property string|null $drained_fluids
 * @property int $truck_id
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Truck $truck
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SafetyInspection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SafetyInspection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SafetyInspection query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SafetyInspection whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SafetyInspection whereDrainedFluids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SafetyInspection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SafetyInspection whereReplacedParts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SafetyInspection whereTruckAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SafetyInspection whereTruckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SafetyInspection whereTruckMileage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SafetyInspection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SafetyInspection extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'safety_inspection';

    protected $fillable = [
        'date', 'truck_age', 'truck_mileage', 'replaced_parts', 'drained_fluids', 'truck_id'
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck_id');
    }

}