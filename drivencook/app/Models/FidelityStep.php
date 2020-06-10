<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FidelityStep extends Model
{
    protected $table = 'fidelity_step';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'step', 'reduction', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
