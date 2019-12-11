<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Date extends Model
{
    use LogsActivity;
    protected $guarded = [];
    protected static $logUnguarded = true;
    // protected static $recordEvents = ['created', 'deleted'];

    public function wajba()
    {
        return $this->belongsTo('App\Experience');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    // public function time()
    // {
    //     return $this->hasOne('App\Time');
    // }
}
