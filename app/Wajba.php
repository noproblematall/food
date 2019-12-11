<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Wajba extends Model
{
    use LogsActivity;
    protected $guarded = [];

    protected static $logUnguarded = true;
    protected static $recordEvents = ['created', 'deleted'];

    public function photos()
    {
        return $this->morphMany('App\Photo', 'photoable');
    }

    public function histories()
    {
        return $this->morphMany('App\History', 'historable');
    }

    public function place_category()
    {
        return $this->belongsTo('App\PlaceCategory', 'place_category_id');
    }

    public function food_category()
    {
        return $this->belongsTo('App\FoodCategory', 'food_category_id');
    }

    // public function city()
    // {
    //     return $this->belongsTo('App\City', '');
    // }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }    

    public function time()
    {
        return $this->hasOne('App\Time');
    }

    public function dates()
    {
        return $this->hasMany('App\Date');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function host()
    {
        return $this->belongsTo('App\Host');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function activities()
    {
        return $this->morphMany('Spatie\Activitylog\Models\Activity', 'subject');
    }

    // public function wajba_dates()
    // {
    //     return $this->hasMany('App\WajbaDate');
    // }

    public function count_city() {
        return self::where('city_name', $this->city_name)->count();
    }

    public function count_place() {
        return self::where('place_category_id', $this->place_category_id)->count();
    }

    public function count_food() {
        return self::where('food_category_id', $this->food_category_id)->count();
    }
}
