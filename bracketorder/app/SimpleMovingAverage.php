<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property array|null|string user_id
 * @property array|null|string sma_number_1
 * @property array|null|string sma_number_2
 * @property array|null|string sma_number_3
 * @property array|null|string periods_1
 * @property array|null|string periods_2
 * @property array|null|string periods_3
 * @property array|null|string color_1
 * @property array|null|string color_2
 * @property array|null|string color_3
 */
class SimpleMovingAverage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'sma_number_1', 'sma_number_2', 'sma_number_3', 'periods_1', 'periods_2', 'periods_3', 'color_2', 'color_2', 'color_3'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
