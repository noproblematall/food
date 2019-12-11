<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Time extends Model
{
    use LogsActivity;
    protected $guarded = [];
    protected static $logUnguarded = true;
    // protected static $recordEvents = ['created', 'deleted'];

    // public function date()
    // {
    //     return $this->belongsTo('App\Date');
    // }

    public function wajba()
    {
        return $this->belongsTo('App\Wajba');
    }

    // public function booking()
    // {
    //     return $this->hasOne('App\Booking');
    // }

    // public function wajba_date()
    // {
    //     return $this->belongsTo('App\WajbaDate', 'wajba_date_id');
    // }
}
