<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'city_id', 'latitude', 'longitude', 'city', 'postcode', 'country'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->with('country');
    }
}
