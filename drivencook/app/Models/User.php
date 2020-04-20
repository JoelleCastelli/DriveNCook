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
        'lastname', 'firstname', 'birthdate', 'pseudo', 'email', 'role', 'driving_licence', 'social_security', 'password',
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

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'user');
    }

    public function monthly_licence_fees()
    {
        return $this->hasMany(MonthlyLicenseFee::class, 'user');
    }

    public function last_monthly_licence_fees()
    {
        return $this->hasOne(MonthlyLicenseFee::class, 'user')->orderByDesc('id');
    }

    public function last_paid_licence_fees()
    {
        return $this->hasOne(MonthlyLicenseFee::class, 'user')->where('status', '=', 'Payée')->orderByDesc('id');
    }
}
