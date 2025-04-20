<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
       try {
            $notifications = Notification::where('user_id', $request->user()->id)->get();
            return ResponseHelper::success($notifications, 'Notification retrieved.');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
