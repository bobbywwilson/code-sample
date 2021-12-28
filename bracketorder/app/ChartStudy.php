<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property array|null|string user_id
 * @property array|null|string indicator
 */
class ChartStudy extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'indicator'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
