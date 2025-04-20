<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'user_id',
        'weekday',
        'start_time',
        'end_time',
        'time_zone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
