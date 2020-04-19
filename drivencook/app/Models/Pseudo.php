<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pseudo extends Model
{
    protected $table = 'pseudo';

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class,'pseudo');
    }

}