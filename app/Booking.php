<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Booking extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;
    use LogsActivity;
    protected $guarded = [];

    protected static $logUnguarded = true;
    protected static $recordEvents = ['created', 'deleted'];
    protected static $logName = 'booking';

    public function host()
    {
        return $this->belongsToThrough('App\Host', 'App\Wajba');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function wajba()
    {
        return $this->belongsTo('App\Wajba');
    }

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }

    // public function histories()
    // {
    //     return $this->morphMany('App\History', 'historable');
    // }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    // public function time()
    // {
    //     return $this->belongsTo('App\Time');
    // }

    public function date()
    {
        return $this->belongsTo('App\Date');
    }

    public function activities()
    {
        return $this->morphMany('Spatie\Activitylog\Models\Activity', 'subject');
    }
}
