<?php


namespace App\Models;


/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property float|null $amount
 * @property int|null $discount_amount
 * @property string|null $date_emitted
 * @property string|null $date_paid
 * @property string|null $reference
 * @property int|null $monthly_fee
 * @property int|null $initial_fee
 * @property int|null $franchisee_order
 * @property int|null $client_order
 * @property string|null $status
 * @property int $user_id
 * @property int|null $purchase_order_id
 * @property int|null $sale_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereClientOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereDateEmitted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereDatePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereFranchiseeOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereInitialFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereMonthlyFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice wherePurchaseOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereSaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereUserId($value)
 * @mixin \Eloquent
 */
class Invoice extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'invoice';

    protected $fillable = [
        'amount', 'date_emitted', 'date_paid', 'status', 'user_id', 'monthly_fee', 'initial_fee', 'purchase_order_id',
        'franchisee_order', 'client_order', 'sale_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}