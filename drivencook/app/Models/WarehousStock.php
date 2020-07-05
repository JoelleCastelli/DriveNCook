<?php


namespace App\Models;


/**
 * App\Models\WarehousStock
 *
 * @property int $warehouse_id
 * @property int $dish_id
 * @property int|null $quantity
 * @property float|null $warehouse_price
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Dish $dish
 * @property-read \App\Models\Warehouse $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WarehousStock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WarehousStock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WarehousStock query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WarehousStock whereDishId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WarehousStock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WarehousStock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WarehousStock whereWarehouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WarehousStock whereWarehousePrice($value)
 * @mixin \Eloquent
 */
class WarehousStock extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'warehouse_stock';

    protected $fillable = [
        'warehouse_id', 'dish_id', 'quantity', 'warehouse_price'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

}