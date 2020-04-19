<?php


namespace App\Models;


class Country extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'country';

    protected $fillable = ['name'];


    public function cities()
    {
        return $this->hasMany(City::class, 'country');
    }

}