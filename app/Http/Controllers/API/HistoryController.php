<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class HistoryController extends Controller
{
    public function get_wajba_history(Request $request)
    {
        $wajba_id = $request->get('wajba_id');
        $user_id = Auth::id();
        if (Activity::where('causer_id', $user_id)->where('subject_id', $wajba_id)->exists()) {
            $history = Activity::with('causer', 'subject')->where('causer_id', $user_id)->where('subject_id', $wajba_id)->get();            
            return response(compact('history'), 200);
        } else {
           return response([
               'error' => "Can't find history"
           ], 200);
        }

    }

    public function get_booking_history(Request $request)
    {
        $booking_id = $request->get('booking_id');
        $user_id = Auth::id();
        if (Activity::where('causer_id', $user_id)->where('subject_id', $booking_id)->exists()) {
            $history = Activity::where('causer_id', $user_id)->where('subject_id', $booking_id)->get();            
            return response(compact('history'), 200);
        } else {
           return response([
               'error' => "Can't find history"
           ], 200);
        }
    }

    public function delete_history(Request $request)
    {
        $history_id = $request->history_id;
        if (Activity::where('id',$history_id)->exists()) {
            Activity::find($history_id)->delete();
            return response([
                'success' => 'success'
            ], 200);
        } else {
            return response([
                'error' => "Can't find the history"
            ], 200);
        }
        
    }
}
