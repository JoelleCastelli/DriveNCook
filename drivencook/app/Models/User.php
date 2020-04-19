<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname', 'firstname', 'birthdate', 'pseudo', 'email', 'role', 'driving_license', 'social_security', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'new_pwd_code',
    ];

    public function pseudo()
    {
        return $this->belongsTo(Pseudo::class, 'pseudo');
    }
}
