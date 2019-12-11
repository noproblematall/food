<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    protected $guarded = [];

    // public function photo()
    // {
    //     return $this->morphOne('App\Photo', 'photoable');
    // }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function wajbas()
    {
        return $this->hasMany('App\Wajba');
    }

    public function bookings()
    {
        return $this->hasManyThrough('App\Booking', 'App\Wajba');
    }
}
