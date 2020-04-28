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
        'lastname', 'firstname', 'birthdate', 'pseudo_id', 'email', 'role', 'driving_licence', 'social_security', 'password',
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
        return $this->belongsTo(Pseudo::class, 'pseudo_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'user_id');
    }

    public function monthly_licence_fees()
    {
        return $this->hasMany(MonthlyLicenseFee::class, 'user_id');
    }

    public function last_monthly_licence_fee()
    {
        return $this->hasOne(MonthlyLicenseFee::class, 'user_id')->orderByDesc('id');
    }

    public function last_paid_licence_fee()
    {
        return $this->hasOne(MonthlyLicenseFee::class, 'user_id')->where('status', '=', 'Payée')->orderByDesc('id');
    }

    public function truck()
    {
        return $this->hasOne(Truck::class, 'user_id')->with('location');
    }
}
