<?php


namespace App\Models;


class Sale extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'sale';

    protected $fillable = [
        'payment_method', 'online_order', 'date', 'user_franchised', 'user_client',
    ];

    public function user_franchised()
    {
        return $this->belongsTo(User::class, 'user_franchised')->with('pseudo')->with('truck');
    }

    public function user_client()
    {
        return $this->belongsTo(User::class, 'user_client');
    }

    public function sold_dishes()
    {
        return $this->hasMany(SoldDish::class, 'sale_id')->with('dish');
    }

}