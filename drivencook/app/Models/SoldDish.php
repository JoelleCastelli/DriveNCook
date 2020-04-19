<?php


namespace App\Models;


class SoldDish extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'sold_dish';

    protected $fillable = ['dish', 'sale', 'quantity'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish');
    }

}