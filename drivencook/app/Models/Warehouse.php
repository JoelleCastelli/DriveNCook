<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouse';

    protected $fillable = [
        'name', 'address', 'city_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function stock()
    {
        return $this->hasMany(WarehousStock::class, 'warehouse_id')->with('dish');
    }

    public function purchase_order()
    {
        return $this->hasMany(PurchaseOrder::class, 'warehouse_id')
            ->with('purchased_dishes')
            ->with('user');
    }

    public function available_dishes()
    {
        return $this->hasMany(WarehousStock::class, 'warehouse_id')
                    ->where('quantity', '>', 0)
                    ->with('dish');
    }
}