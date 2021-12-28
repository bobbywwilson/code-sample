<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property array|null|string user_id
 * @property array|null|string sector
 * @property array|null|string ticker_symbol
 * @property false|string created_at
 */
class Watchlist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'sector', 'ticker_symbol'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
