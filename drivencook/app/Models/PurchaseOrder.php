<?php


namespace App\Models;


class PurchaseOrder extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'purchase_order';

    protected $fillable = ['user', 'date'];

    public function purchased_dishes()
    {
        return $this->hasMany(PurchasedDish::class, 'purchase_order');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

}