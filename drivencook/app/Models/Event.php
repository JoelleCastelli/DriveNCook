<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $type
 * @property string $date_start
 * @property string $date_end
 * @property string $title
 * @property string $description
 * @property int|null $location_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventInvited[] $invited
 * @property-read int|null $invited_count
 * @property-read \App\Models\Location|null $location
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUserId($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    protected $table = 'event';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'type', 'date_start', 'date_end', 'location_id', 'title', 'description', 'user_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @return BelongsTo
     * @var array
     */
    /*protected $hidden = [

    ];*/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function invited()
    {
        return $this->hasMany(EventInvited::class, 'event_id')->with('user');
    }
}
