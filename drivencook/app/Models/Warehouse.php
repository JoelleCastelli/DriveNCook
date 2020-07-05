<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Warehouse
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $location_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WarehousStock[] $available_dishes
 * @property-read int|null $available_dishes_count
 * @property-read \App\Models\Location|null $location
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchaseOrder[] $purchase_order
 * @property-read int|null $purchase_order_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WarehousStock[] $stock
 * @property-read int|null $stock_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Warehouse extends Model
{
    protected $table = 'warehouse';

    protected $fillable = [
        'name', 'location_id'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function stock()
    {
        return $this->hasMany(WarehousStock::class, 'warehouse_id')->with('dish');
    }

    public function purchase_order()
    {
        return $this->hasMany(PurchaseOrder::class, 'warehouse_id')
            ->with('purchased_dishes')
            ->with('user');
    }

    public function available_dishes()
    {
        return $this->hasMany(WarehousStock::class, 'warehouse_id')
                    ->where('quantity', '>', 0)
                    ->with('dish');
    }
}