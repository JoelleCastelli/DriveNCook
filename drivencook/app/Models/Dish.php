<?php


namespace App\Models;


/**
 * App\Models\Dish
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $category
 * @property string|null $description
 * @property string|null $diet
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FranchiseeStock[] $franchisee_stock
 * @property-read int|null $franchisee_stock_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchasedDish[] $purchased_dish
 * @property-read int|null $purchased_dish_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WarehousStock[] $warehouse_stock
 * @property-read int|null $warehouse_stock_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereDiet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dish whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dish extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'dish';

    protected $fillable = [
        'name', 'category', 'description', 'diet'
    ];

    public function warehouse_stock()
    {
        return $this->hasMany(WarehousStock::class, 'dish_id');
    }

    public function franchisee_stock()
    {
        return $this->hasMany(FranchiseeStock::class, 'dish_id');
    }

    public function purchased_dish()
    {
        return $this->hasMany(PurchasedDish::class, 'dish_id');
    }
}