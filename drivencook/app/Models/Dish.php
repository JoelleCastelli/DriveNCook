<?php


namespace App\Models;


class Dish extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'dish';

    protected $fillable = [
        'name', 'category', 'warehouse_price', 'quantity', 'warehouse'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'dish');
    }
}