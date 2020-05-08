<?php


namespace App\Models;


class Invoice extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'invoice';

    protected $fillable = [
        'amount', 'date_emitted', 'date_paid', 'status', 'user_id', 'monthly_licence_fee'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}