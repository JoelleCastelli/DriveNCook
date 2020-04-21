<?php


namespace App\Models;


class MonthlyLicenseFee extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'monthly_licence_fee';

    protected $fillable = [
        'amount', 'date_emitted', 'date_paid', 'status', 'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}