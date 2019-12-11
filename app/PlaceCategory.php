<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceCategory extends Model
{
    protected $guarded = [];

    public function photo()
    {
        return $this->morphOne('App\Photo', 'photoable');
    }

    public function wajbas()
    {
        return $this->hasMany('App\Wajba');
    }
}
