<?php


namespace App\Models;


class PurchaseOrder extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'purchase_order';

    protected $fillable = ['user_id', 'warehouse_id', 'date', 'status'];

    public function purchased_dishes()
    {
        return $this->hasMany(PurchasedDish::class, 'purchase_order_id')->with('dish');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->with('pseudo');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id')->with('location');
    }

}