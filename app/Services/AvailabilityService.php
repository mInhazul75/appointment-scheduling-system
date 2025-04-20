<?php

namespace App\Services;

use App\Models\Availability;
use Illuminate\Support\Facades\Auth;

class AvailabilityService
{
    public function store(array $slots): void
    {
        foreach ($slots as $slot) {
            Availability::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'weekday' => $slot['weekday'],
                ],
                [
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                    'time_zone' =>  $slot['time_zone'],
                ]
            );
        }
    }

    public function show($hostId)
    {
        return Availability::where('user_id', $hostId)->first();
    }
}
