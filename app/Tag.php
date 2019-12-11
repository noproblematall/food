<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function wajbas()
    {
        return $this->belongsToMany('App\Wajba');
    }
}
