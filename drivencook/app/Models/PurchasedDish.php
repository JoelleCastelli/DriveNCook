<?php


namespace App\Models;


/**
 * App\Models\PurchasedDish
 *
 * @property int $purchase_order_id
 * @property int $dish_id
 * @property int|null $quantity
 * @property float|null $unit_price
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $quantity_sent
 * @property-read \App\Models\Dish $dish
 * @property-read \App\Models\PurchaseOrder $purchase_order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchasedDish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchasedDish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchasedDish query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchasedDish whereDishId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchasedDish wherePurchaseOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchasedDish whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchasedDish whereQuantitySent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchasedDish whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchasedDish whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PurchasedDish extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'purchased_dish';

    protected $fillable = ['purchase_order_id', 'dish_id', 'unit_price', 'quantity', 'quantity_sent'];

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }
}