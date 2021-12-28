<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimpleMovingAverage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'sma_number', 'periods', 'color'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
