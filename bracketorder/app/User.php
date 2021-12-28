<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'name', 'email', 'password', 'provider', 'provider_id', 'last_login', 'user_ip_address'
    ];

    public function watchlists()
    {
        return $this->hasMany('App\Watchlist');
    }

    public function chart_studies()
    {
        return $this->hasMany('App\ChartStudy');
    }

    public function simple_moving_averages()
    {
        return $this->hasMany('App\SimpleMovingAverage');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


}
