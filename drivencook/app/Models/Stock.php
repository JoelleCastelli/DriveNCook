<?php


namespace App\Models;


class Stock extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'stock';

    protected $fillable = [
        'user_id', 'dish_id', 'quantity', 'unit_price'
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