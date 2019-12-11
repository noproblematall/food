<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'lastName', 'email', 'password', 'role_id', 'host_id', 'mobile', 'mobile_verified', 'status_id', 'gender', 'city'
    ];

    public $with = ['role', 'host'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function photo()
    {
        return $this->morphOne('App\Photo', 'photoable');
    }
    
    // public function histories()
    // {
    //     return $this->morphMany('App\History', 'historable');
    // }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function host()
    {
        return $this->belongsTo('App\Host');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function getFullNameAttribute()
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getAvatarAttribute()
    {
        return strtoupper(substr($this->firstName, 0, 1)) . strtoupper(substr($this->lastName, 0, 1));
    }
}
