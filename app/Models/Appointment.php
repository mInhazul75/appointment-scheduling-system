<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'host_id',
        'guest_id',
        'start_time',
        'end_time',
        'status',
        'notes',
        'time_zone'
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function guest()
    {
        return $this->belongsTo(User::class, 'guest_id');
    }
}
