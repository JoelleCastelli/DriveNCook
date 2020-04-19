<?php


namespace App\Models;


class Stock extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'stock';

    protected $fillable = [
        'user', 'dish', 'quantity', 'unit_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish');
    }
}