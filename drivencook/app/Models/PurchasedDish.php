<?php


namespace App\Models;


class PurchasedDish extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'purchased_dish';

    protected $fillable = ['purchase_order', 'dish_id', 'quantity'];

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }
}