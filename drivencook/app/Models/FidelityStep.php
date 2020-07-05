<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FidelityStep
 *
 * @property int $id
 * @property int $step
 * @property int $reduction
 * @property int $user_id
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FidelityStep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FidelityStep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FidelityStep query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FidelityStep whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FidelityStep whereReduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FidelityStep whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FidelityStep whereUserId($value)
 * @mixin \Eloquent
 */
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
