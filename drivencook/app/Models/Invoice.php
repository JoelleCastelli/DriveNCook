<?php


namespace App\Models;


class Invoice extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'invoice';

    protected $fillable = [
        'amount', 'date_emitted', 'date_paid', 'status', 'user_id', 'monthly_fee', 'initial_fee', 'purchase_order_id',
        'franchisee_order', 'client_order', 'sale_id', 'discount_amount'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}