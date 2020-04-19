<?php


namespace App\Models;


class PurchasedDish extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'purchased_dish';

    protected $fillable = ['purchase_order', 'dish', 'quantity'];

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish');
    }
}