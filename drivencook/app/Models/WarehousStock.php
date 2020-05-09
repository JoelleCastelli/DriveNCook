<?php


namespace App\Models;


class WarehousStock extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'warehouse_stock';

    protected $fillable = [
        'warehouse_id', 'dish_id', 'quantity', 'warehouse_price'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

}