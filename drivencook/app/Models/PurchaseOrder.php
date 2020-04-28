<?php


namespace App\Models;


class PurchaseOrder extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'purchase_order';

    protected $fillable = ['user_id', 'date'];

    public function purchased_dishes()
    {
        return $this->hasMany(PurchasedDish::class, 'purchase_order_id')->with('dish');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}