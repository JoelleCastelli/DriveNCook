<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\EventInvited
 *
 * @property int $event_id
 * @property int $user_id
 * @property-read \App\Models\Event $event
 * @property-read \App\Models\Event $event_30
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventInvited newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventInvited newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventInvited query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventInvited whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventInvited whereUserId($value)
 * @mixin \Eloquent
 */
class EventInvited extends Model
{
    protected $table = 'event_invited';


    protected $fillable = ['user_id', 'event_id'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function event_30()
    {
        return $this->belongsTo(Event::class, 'event_id')->where('date_start', '>=', Carbon::now()->subMonth());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
