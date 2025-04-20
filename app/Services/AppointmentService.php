<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AppointmentService
{
    public function store($data)
    {
        // Check for double booking
        $overlap = Appointment::where('host_id', $data['host_id'])
            ->where('status', '!=', 'canceled')
            ->where(function ($query) use ($data) {
                $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                    ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']]);
            })
            ->exists();

        if ($overlap) {
            return ['error' => true, 'message' => 'Time slot not available.'];
        }

        $appointment = Appointment::create([
            'host_id' => $data['host_id'],
            'guest_id' => Auth::id(),
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
            'time_zone' => $data['time_zone'],
        ]);


        Notification::create([
            'appointment_id' => $appointment['id'],
            'user_id' => $data['host_id'],
            'message' => 'New appointment booked by ' . Auth::user()->name,
        ]);

        Notification::create([
            'appointment_id' => $appointment['id'],
            'user_id' => Auth::id(),
            'message' => 'You booked an appointment with host ID ' . $data['host_id'],
        ]);

    }

    public function index($filters)
    {
        $query = Appointment::query();

        if (isset($filters['host_id'])) {
            $query->where('host_id', $filters['host_id']);
        }

        if (isset($filters['guest_id'])) {
            $query->where('guest_id', $filters['guest_id']);
        }

        return $query->paginate(10);
    }

    public function update($id, $status)
    {
        $appointment = Appointment::findOrFail($id);
        if(!$appointment){
            return ['error' => true, 'message' => 'Not Found.'];
        }
        $appointment->update(['status' => $status]);

        return $appointment;
    }
}
