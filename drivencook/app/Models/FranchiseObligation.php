<?php


namespace App\Models;


/**
 * App\Models\FranchiseObligation
 *
 * @property int $id
 * @property string|null $date_updated
 * @property float|null $entrance_fee
 * @property float|null $revenue_percentage
 * @property float|null $warehouse_percentage
 * @property int|null $billing_day
 * @property int|null $user_id
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseObligation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseObligation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseObligation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseObligation whereBillingDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseObligation whereDateUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseObligation whereEntranceFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseObligation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseObligation whereRevenuePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseObligation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FranchiseObligation whereWarehousePercentage($value)
 * @mixin \Eloquent
 */
class FranchiseObligation extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'franchise_obligation';

    protected $fillable = [
        'date_updated', 'entrance_fee', 'revenue_percentage', 'warehouse_percentage', 'billing_day', 'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }
}