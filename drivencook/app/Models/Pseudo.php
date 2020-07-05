<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pseudo
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pseudo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pseudo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pseudo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pseudo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pseudo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pseudo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pseudo extends Model
{
    protected $table = 'pseudo';

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasOne(User::class,'pseudo_id');
    }

}