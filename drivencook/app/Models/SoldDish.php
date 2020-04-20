<?php


namespace App\Models;


class SoldDish extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'sold_dish';

    protected $fillable = ['dish_id', 'sale', 'quantity'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

}