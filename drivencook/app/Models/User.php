<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as BasicAuthenticatable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $role
 * @property string|null $password
 * @property string|null $remember_token
 * @property string|null $birthdate
 * @property int|null $pseudo_id
 * @property string|null $telephone
 * @property string|null $driving_licence
 * @property string|null $social_security
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $loyalty_point
 * @property string|null $password_token
 * @property int|null $opt_in
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sale[] $client_orders
 * @property-read int|null $client_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventInvited[] $event_invited
 * @property-read int|null $event_invited_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventInvited[] $event_invited_30
 * @property-read int|null $event_invited_30_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \App\Models\Invoice|null $last_invoice
 * @property-read \App\Models\Invoice|null $last_paid_invoice_fee
 * @property-read \App\Models\Pseudo|null $pseudo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchaseOrder[] $purchase_order
 * @property-read int|null $purchase_order_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sale[] $sales
 * @property-read int|null $sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FranchiseeStock[] $stocks
 * @property-read int|null $stocks_count
 * @property-read \App\Models\Truck|null $truck
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDrivingLicence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLoyaltyPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOptIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePasswordToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePseudoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSocialSecurity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        'lastname', 'firstname', 'birthdate', 'telephone', 'pseudo_id', 'email', 'role', 'driving_licence',
        'social_security', 'password', 'password_token', 'loyalty_point', 'opt_in'
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
        return $this->hasMany(FranchiseeStock::class, 'user_id')->with('dish');
    }

    public function purchase_order()
    {
        return $this->hasMany(PurchaseOrder::class, 'user_id')->with('purchased_dishes')->with('warehouse');
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
            ->where('monthly_fee', 1)
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

    public function client_orders()
    {
        return $this->hasMany(Sale::class, 'user_client')->with('sold_dishes');
    }

    public function event_invited()
    {
        return $this->hasMany(EventInvited::class, 'user_id')->with('event');
    }

    public function event_invited_30()
    {
        return $this->hasMany(EventInvited::class, 'user_id')
            ->with('event_30');
    }
}
