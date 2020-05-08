<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as BasicAuthenticatable;

class User extends Model implements Authenticatable
{
    use BasicAuthenticatable;

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
        'new_pwd_code',
    ];

    public function pseudo()
    {
        return $this->belongsTo(Pseudo::class, 'pseudo_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'user_id')->with('dish');
    }

    public function purchase_order()
    {
        return $this->hasMany(PurchaseOrder::class, 'user_id')->with('purchased_dishes');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id');
    }

    public function last_invoice()
    {
        return $this->hasOne(Invoice::class, 'user_id')->orderByDesc('id');
    }

    public function last_paid_invoice_fee()
    {
        return $this->hasOne(Invoice::class, 'user_id')
                    ->where('status', 'Payée')
                    ->where('monthly_licence_fee', 1)
                    ->orderByDesc('id');
    }

    public function truck()
    {
        return $this->hasOne(Truck::class, 'user_id')->with('location')->with('last_safety_inspection');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_franchised')->with('sold_dishes');
    }
}
