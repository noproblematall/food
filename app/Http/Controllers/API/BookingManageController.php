<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Booking;
use App\Payment;
use App\Notification;
use App\Wajba;
use App\Events\WajbaEvent;

use App\Http\Resources\Booking as BookingResource;

class BookingManageController extends Controller
{
    public function add_booking(Request $request)
    {
        if(!Booking::where('time_id', $request->get('time_id'))->where('user_id', Auth::id())->exists()){
            $input = $request->all();
            $wajba_id = $request->get('wajba_id');
            if(!Wajba::find($wajba_id)){
                return response([
                    'error' => "Can't find the wajba."
                ], 422);
            }
            $input['user_id'] = Auth::id();
            
            $booking = Booking::create($input);
    
            // ----------- have to modify new "numberOfSeatsAvailable" in time table ---------------------
            // $price = Wajba::find($request->get('wajba_id'))->price;
            // $total_price = 
            $name = Auth::user()->full_name;
            $message_en = '<strong>' . $name . '</strong> booked wajba <strong>"' . Wajba::find($wajba_id)->title . '"</strong> at ' . date('Y-m-d H:i:s'). '.';
            $message_ar = '<strong>' . $name . '</strong> booked wajba <strong>"' . Wajba::find($wajba_id)->title . '"</strong> at ' . date('Y-m-d H:i:s'). '.(AR)';
            $link = "/admin/booking_detail/" . $booking->id;
            $info = array(
                'type'  => 'new_book',
                'comment_en' => $message_en,
                'comment_ar' => $message_ar,
                'link' => $link,
            );
            $info['user_id'] = Wajba::find($wajba_id)->host->user->id;
            Notification::create($info);
            // $info['user_id'] = 1;
            // Notification::create($info);
            event(new WajbaEvent(Wajba::find($wajba_id)->host->user->id, $message_en, $link));
            // event(new WajbaEvent(1, $message_en, $link));
            return new BookingResource($booking);
        }else{
            return response([
                'error' => 'You already have been booked this food.'
            ], 422);
        }
    }

    public function edit_booking(Request $request)
    {
        $booking_id = $request->get('booking_id');
        if (Booking::find($booking_id)) {
            $input = $request->all();
            $input['user_id'] = Auth::id();
            unset($input['booking_id']);
            $wajba_id = $request->wajba_id;
            Booking::where('id', $booking_id)->update($input);
            activity('booking')->performedOn(Booking::find($booking_id))->log('updated');

            $name = Auth::user()->full_name;
            $message_en = '<strong>' . $name . '</strong> updated booking of the wajba <strong>"' . Wajba::find($wajba_id)->title . '"</strong> at ' . date('Y-m-d H:i:s'). '.';
            $message_ar = '<strong>' . $name . '</strong> updated booking of the wajba <strong>"' . Wajba::find($wajba_id)->title . '"</strong> at ' . date('Y-m-d H:i:s'). '.(AR)';
            $link = "/admin/booking_detail/" . $booking_id;
            $info = array(
                'type'  => 'update_book',
                'comment_en' => $message_en,
                'comment_ar' => $message_ar,
                'link' => $link,
            );
            $info['user_id'] = Wajba::find($wajba_id)->host->user->id;
            Notification::create($info);
            event(new WajbaEvent(Wajba::find($wajba_id)->host->user->id, $message_en, $link));

            return new BookingResource(Booking::find($booking_id));
        }else{
            return response([
                'error' => "Can't find the booking"
            ], 422);
        }
    }

    public function delete_booking(Request $request)
    {
        $booking_id = $request->get('booking_id');
        if(Booking::find($booking_id) && Booking::find($booking_id)->user_id == Auth::id()){
            $wajba_id = Booking::find($booking_id)->wajba_id;
            Booking::find($booking_id)->delete();
            $name = Auth::user()->full_name;
            $message_en = '<strong>' . $name . '</strong> deleted booking of the wajba <strong>"' . Wajba::find($wajba_id)->title . '"</strong> at ' . date('Y-m-d H:i:s'). '.';
            $message_ar = '<strong>' . $name . '</strong> deleted booking of the wajba <strong>"' . Wajba::find($wajba_id)->title . '"</strong> at ' . date('Y-m-d H:i:s'). '.(AR)';
            $link = "/admin/booking_detail/" . $booking_id;
            $info = array(
                'type'  => 'delete_book',
                'comment_en' => $message_en,
                'comment_ar' => $message_ar,
                'link' => $link,
            );
            $info['user_id'] = Wajba::find($wajba_id)->host->user->id;
            Notification::create($info);
            event(new WajbaEvent(Wajba::find($wajba_id)->host->user->id, $message_en, $link));

            return response([
                'success' => 'success'
            ], 200);
        }else{
            return response([
                'error' => "Can't find the booking"
            ], 422);
        }
    }

    public function get_booking_by_id(Request $request)
    {
        return new BookingResource(Booking::find($request->booking_id));
    }

    public function get_my_bookings(Request $request)
    {
        return BookingResource::collection(Auth::user()->bookings);
    }

    public function change_booking_status(Request $request)
    {
        $status_id = $request->get('status_id');
        $booking_id = $request->get('booking_id');
        $booking = Booking::find($booking_id);
        $booking->status_id = $status_id;
        if($status_id == 1 && $booking->payment_id == null){
            $payment = Payment::create();
            $payment_id = $payment->id;
            $booking->payment_id = $payment_id;
            activity('booking')->performedOn($payment)->log('payment_created');
        }
        $booking->save();

        activity('booking')->performedOn(Booking::find($booking_id))->withProperties(['status' => $booking->status->type])->log('status_changed');
        $comment_en = 'Your booking is updated to ' . '"' . $booking->status->type .'" status at ' . date('Y-m-d H:i:s'). '.';
        $comment_ar = 'Your booking is updated to ' . '"' . $booking->status->type .'" status at ' . date('Y-m-d H:i:s'). '.(AR)';
        // you have to add $link......
        Notification::create([
            'type'  => 'booking_status_change',
            'comment_en' => $comment_en,
            'comment_ar' => $comment_ar,
            'user_id' => $booking->user->id,
        ]);
        event(new WajbaEvent($booking->user->id, $comment_en));

        return response([
            'new_status' => $booking->status->type
        ], 200);
    }

    public function add_payment(Request $request)
    {
        $booking_id = $request->get('booking_id');
        $paymentRef = $request->get('paymentRef');
        $totalAmount = $request->get('totalAmount');
        // you have to add balance to the host(% of totalAmount)
        $status = $request->get('status');
        $payment = Booking::find($booking_id)->payment;
        $payment->paymentRef = $paymentRef;
        $payment->status = $status;
        $payment->save();
        activity('booking')->performedOn($payment)->withProperties(['paymentRef' => $paymentRef, 'status' => $status])->log('payment_status_changed');
        // Notification::create([
        //     'type'  => 'new_payment',
        //     'comment_en' => 'Your booking "' . $booking->title . '" is updated to ' . '"' . $booking->status->type .'" at ' . date('Y-m-d H:i:s'). '.',
        //     'comment_ar' => 'Your booking "' . $booking->title . '" is updated to ' . '"' . $booking->status->type .'" at ' . date('Y-m-d H:i:s'). '.(AR)',
        //     'user_id' => $booking->user->id,
        // ]);

        return response(compact('payment'), 200);
    }

    public function change_payment_status(Request $request)
    {
        $payment_id = $request->get('payment_id');
        $status = $request->get('status');
        $paymentRef = $request->get('paymentRef');
        $payment = Payment::find($payment_id);
        $payment->status = $status;
        $payment->paymentRef = $paymentRef;
        $payment->save();
        activity('booking')->performedOn(Payment::find($payment_id))->withProperties(['paymentRef' => $paymentRef, 'status' => $status])->log('payment_status_changed');

        return response([
            'success' => 'success'
        ], 200);
    }
}
