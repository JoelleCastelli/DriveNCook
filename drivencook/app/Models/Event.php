<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
