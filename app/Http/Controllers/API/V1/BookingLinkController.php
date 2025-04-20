<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BookingLinkService;
use App\Helpers\ResponseHelper;

class BookingLinkController extends Controller
{
    protected $service;

    public function __construct(BookingLinkService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $link = $this->service->create();
        return ResponseHelper::success($link, 'Booking link created.');
    }

    public function show($slug)
    {
        $availability = $this->service->getAvailabilityBySlug($slug);
        return ResponseHelper::success($availability, 'Host availability retrieved.');
    }
}
