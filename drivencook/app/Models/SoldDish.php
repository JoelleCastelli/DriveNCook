<?php


namespace App\Models;


/**
 * App\Models\SoldDish
 *
 * @property int $dish_id
 * @property int $sale_id
 * @property float|null $unit_price
 * @property int|null $quantity
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Dish $dish
 * @property-read \App\Models\Sale $sale
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoldDish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoldDish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoldDish query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoldDish whereDishId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoldDish whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoldDish whereSaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoldDish whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoldDish whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SoldDish extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'sold_dish';

    protected $fillable = ['dish_id', 'sale', 'quantity','unit_price'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

}