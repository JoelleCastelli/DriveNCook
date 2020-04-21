<?php


namespace App\Models;


class City extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'city';

    protected $fillable = ['name', 'postcode', 'country'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country');
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class, 'city');
    }

}