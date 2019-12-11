<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];

    public function wajba()
    {
        return $this->belongsTo('App\Wajba');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
