<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function wajbas()
    {
        return $this->hasMany('App\Wajba');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
}
