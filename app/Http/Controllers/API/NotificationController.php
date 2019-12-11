<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Notification;

class NotificationController extends Controller
{
    public function get_my_notifications(Request $request)
    {
        $user_id = Auth::id();
        if (Auth::user()->notifications()->exists()) {
            $notify = Auth::user()->notifications;
            return response(compact('notify'), 200);
        } else {
            return response([
                'error' => "Can't find the notifications"
            ], 200);
        }
    }

    public function delete_notifications(Request $request)
    {
        $notify_id = $request->notify_id;
        if (Notification::where('id', $notify_id)->exists()) {
            Notification::find($notify_id)->delete();
        } else {
            return response([
                'error' => "Can't find the notifications"
            ], 200);
        }
        
    }

    public function get_notify_by_id(Request $request)
    {
        $notify_id = $request->notify_id;
        if (Notification::where('id', $notify_id)->exists()) {
            $notify = Notification::find($notify_id);
            return response([
                'data' => $notify
            ], 200);
        } else {
            return response([
                'error' => "Can't find the notifications"
            ], 200);
        }
    }
}
