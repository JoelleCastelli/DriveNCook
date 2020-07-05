<?php


namespace App\Models;


/**
 * App\Models\PurchaseOrder
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $warehouse_id
 * @property string|null $status
 * @property string|null $date
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchasedDish[] $purchased_dishes
 * @property-read int|null $purchased_dishes_count
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Warehouse $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseOrder whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseOrder whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseOrder whereWarehouseId($value)
 * @mixin \Eloquent
 */
class PurchaseOrder extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'purchase_order';

    protected $fillable = ['user_id', 'warehouse_id', 'date', 'status'];

    public function purchased_dishes()
    {
        return $this->hasMany(PurchasedDish::class, 'purchase_order_id')->with('dish');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->with('pseudo');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id')->with('location');
    }

}