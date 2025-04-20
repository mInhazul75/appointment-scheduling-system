<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'appointment_id',
        'message',
        'user_id'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
