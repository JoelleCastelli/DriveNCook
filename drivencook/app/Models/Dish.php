<?php


namespace App\Models;


class Dish extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'dish';

    protected $fillable = [
        'name', 'category'
    ];

    public function warehouse_stock()
    {
        return $this->hasMany(WarehousStock::class, 'dish_id');
    }

    public function franchisee_stock()
    {
        return $this->hasMany(FranchiseeStock::class, 'dish_id');
    }

    public function purchased_dish()
    {
        return $this->hasMany(PurchasedDish::class, 'dish_id');
    }
}