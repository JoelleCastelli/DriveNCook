<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
