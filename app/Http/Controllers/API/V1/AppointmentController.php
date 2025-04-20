<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;

class AppointmentController extends Controller
{
    protected $service;

    public function __construct(AppointmentService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'host_id' => 'required|exists:users,id',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'notes' => 'nullable|string',
                'time_zone' => 'required|string',
            ]);

            if ($validator->fails()) {
                return ResponseHelper::error($validator->errors()->first(), 422);
            }

            $result = $this->service->store($validator->validated());


            return ResponseHelper::success([], 'Appointment booked.');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function index(Request $request)
    {
        $appointments = $this->service->index($request->only(['host_id', 'guest_id']));
        return ResponseHelper::success($appointments);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:confirmed,canceled',
            ]);

            if ($validator->fails()) {
                return ResponseHelper::error($validator->errors()->first(), 422);
            }

            $appointment = $this->service->update($id, $request->status);
            return ResponseHelper::success($appointment, 'Appointment updated.');

            return ResponseHelper::success($appointment, 'Appointment updated.');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage());
            //throw $th;
        }
    }
}
