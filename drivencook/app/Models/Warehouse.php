<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouse';

    protected $fillable = [
        'name', 'address', 'city'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city');
    }
}