<?php


namespace App\Models;


class FranchiseeStock extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'franchisee_stock';

    protected $fillable = [
        'user_id', 'dish_id', 'quantity', 'unit_price', 'menu'
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