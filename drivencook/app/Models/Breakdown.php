<?php


namespace App\Models;


/**
 * App\Models\Breakdown
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $description
 * @property float|null $cost
 * @property string|null $date
 * @property string|null $status
 * @property int $truck_id
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Truck $truck
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Breakdown newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Breakdown newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Breakdown query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Breakdown whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Breakdown whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Breakdown whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Breakdown whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Breakdown whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Breakdown whereTruckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Breakdown whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Breakdown whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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