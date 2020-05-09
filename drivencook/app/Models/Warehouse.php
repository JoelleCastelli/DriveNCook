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
        return $this->hasMany(WarehousStock::class, 'warehouse_id');
    }

    public function purchase_order()
    {
        return $this->hasMany(PurchaseOrder::class, 'warehouse_id');
    }
}