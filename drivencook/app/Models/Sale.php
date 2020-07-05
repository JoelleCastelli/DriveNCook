<?php


namespace App\Models;


/**
 * App\Models\Sale
 *
 * @property int $id
 * @property string|null $payment_method
 * @property int|null $online_order
 * @property string|null $date
 * @property \App\Models\User $user_franchised
 * @property \App\Models\User|null $user_client
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $status
 * @property int|null $discount_amount
 * @property int|null $points_to_return
 * @property string|null $payment_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SoldDish[] $sold_dishes
 * @property-read int|null $sold_dishes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereOnlineOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale wherePointsToReturn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereUserClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereUserFranchised($value)
 * @mixin \Eloquent
 */
class Sale extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'sale';

    protected $fillable = [
        'payment_method', 'online_order', 'date', 'user_franchised', 'user_client',
    ];

    public function user_franchised()
    {
        return $this->belongsTo(User::class, 'user_franchised')->with('pseudo')->with('truck');
    }

    public function user_client()
    {
        return $this->belongsTo(User::class, 'user_client');
    }

    public function sold_dishes()
    {
        return $this->hasMany(SoldDish::class, 'sale_id')->with('dish');
    }

}