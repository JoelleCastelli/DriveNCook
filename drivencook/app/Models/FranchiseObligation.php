<?php


namespace App\Models;


class FranchiseObligation extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'franchise_obligation';

    protected $fillable = [
        'date_updated', 'entrance_fee', 'revenue_percentage', 'warehouse_percentage', 'billing_day', 'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }
}