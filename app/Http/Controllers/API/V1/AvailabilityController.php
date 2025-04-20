<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AvailabilityService;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;

class AvailabilityController extends Controller
{
    protected $service;

    public function __construct(AvailabilityService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'availabilities' => 'required|array',
            'availabilities.*.weekday' => 'required|string',
            'availabilities.*.start_time' => 'required',
            'availabilities.*.end_time' => 'required',
            'availabilities.*.time_zone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors()->first(), 422);
        }

        $this->service->store($validator->validated()['availabilities']);

        return ResponseHelper::success([], 'Availability saved.');
    }

    public function show($hostId)
    {
        $data = $this->service->show($hostId);
        return ResponseHelper::success($data);
    }
}
