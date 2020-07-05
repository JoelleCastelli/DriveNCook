<?php


namespace App\Models;


/**
 * App\Models\FranchiseeStock
 *
 * @property int $user_id
 * @property int $dish_id
 * @property int|null $quantity
 * @property float|null $unit_price
 * @property int $menu
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Dish $dish
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseeStock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseeStock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseeStock query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseeStock whereDishId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseeStock whereMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseeStock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseeStock whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseeStock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseeStock whereUserId($value)
 * @mixin \Eloquent
 */
class FranchiseeStock extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'franchisee_stock';

    protected $fillable = [
        'user_id', 'dish_id', 'quantity', 'unit_price', 'menu'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

}