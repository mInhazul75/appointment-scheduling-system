<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function appointmentsAsHost()
    {
        return $this->hasMany(Appointment::class, 'host_id');
    }

    public function appointmentsAsGuest()
    {
        return $this->hasMany(Appointment::class, 'guest_id');
    }

    public function bookingLinks()
    {
        return $this->hasMany(BookingLink::class);
    }
}