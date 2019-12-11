<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WajbaDate extends Model
{
    protected $guarded = [];

    protected $table = 'wajba_dates';

    public function times()
    {
        return $this->hasMany('App\Time', 'wajba_date_id');
    }

}
