<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Booking;
use App\Wajba;
use App\Date;
use Mail;

class BookingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // if (Auth::user()->host()->exists()) {
        //     return back()->withSuccess('Sorry!, You are host. so, you can\'t create new booking.');
        // }else{
            if (Auth::user()->host) {
                if (Auth::user()->host->wajbas) {
                    if(Auth::user()->host->wajbas()->find($request->get('wajba_id'))){
                        return back();
                    }
                }
            }
                $data = $request->all();
                $wajba_id = $data['wajba_id'];
                $date_id = $data['date_id'];
                $number_males = (int)$data['number_males'];
                $number_females = (int)$data['number_females'];
                $number_childrens = (int)$data['number_childrens'];
                $total_amount = (int)(Wajba::find($wajba_id)->price) * ($number_males + $number_females + $number_childrens);
                Booking::create([
                    'wajba_id' => $wajba_id,
                    'user_id' => Auth::id(),
                    'numberOfFemales' => $number_females,
                    'numberOfMales' => $number_males,
                    'numberOfChildren' => $number_childrens,
                    'totalAmount' => $total_amount,
                    'date_id' => $date_id,
                ]);
                $number_seat_available = Date::find($date_id)->numberOfSeatsAvailable;
                Date::find($date_id)->update([
                    'numberOfSeatsAvailable' => (int)($number_seat_available) - ($number_males + $number_females + $number_childrens),
                ]);

                $host = Wajba::find($wajba_id)->host->user;
                $host_email = $host->email;
                $host_name = $host->full_name;
                $guest_name = Auth::user()->full_name;
                
                $data = array('host_email'=>$host_email, 'host_name'=>$host_name, 'guest_name'=>$guest_name, 'number_males'=>$number_males, 'number_females'=>$number_females, 'number_childrens'=>$number_childrens, 'totalAmount'=>$total_amount);

                Mail::send('emails.order', $data, function($message) use($host_email, $host_name) {
                    $message->to($host_email, $host_name)->subject('New Booking');
                });
            
            return redirect(route('get_guest_booking'))->withSuccess('Your booking is pending now. please wait...');

        // }
    }
    
    public function get_host_booking()
    {
        session(['side_bar' => 'get_host_booking']);
        $user = Auth::user();
        // if ($user->host()->exists()) {
            $bookings = $user->host->bookings;
            return view('host_booking', compact('bookings'));
        // }else{
        //     return view('my_booking');
        // }
    }

    public function get_guest_booking()
    {
        session(['side_bar' => 'get_guest_booking']);
        $user = Auth::user();
        // if ($user->host()->exists()) {
        //     $bookings = $user->host->bookings;
        //     return view('host_booking', compact('bookings'));
        // }else{
            return view('my_booking');
        // }
    }

    public function booking_edit($id)
    {
        $booking = Booking::find($id);
        return view('my_booking_detail', compact('booking'));
    }

    public function booking_detail($id)
    {
        $booking = Booking::find($id);
        return view('host_booking_detail', compact('booking'));
    }

    public function booking_status_change(Request $request)
    {
        $booking_id = $request->get('booking_id');
        $status_id = $request->get('status_id');
        Booking::find($booking_id)->update([
            'status_id' => $status_id,
        ]);

        $booking = Booking::find($booking_id);
        $guest_name = $booking->user->full_name;
        $guest_email = $booking->user->email;
        $total_amount = $booking->totalAmount;
        $date = $booking->date->date;
        $from_time = $booking->wajba->time->fromTime;
        $to_time = $booking->wajba->time->toTime;
        $full_date = $date . ' ' . $from_time . ' ~ ' . $to_time;
        $number_males = $booking->numberOfMales;
        $number_females = $booking->numberOfFemales;
        $number_childrens = $booking->numberOfChildren;

        $data = array('guest_name'=>$guest_name, 'number_males'=>$number_males, 'number_females'=>$number_females, 'number_childrens'=>$number_childrens, 'totalAmount'=>$total_amount, 'full_date'=>$full_date, 'status_id'=>$status_id);

        Mail::send('emails.booking', $data, function($message) use($guest_email, $guest_name) {
            $message->to($guest_email, $guest_name)->subject('Booking Status');
        });

        return back();
    }
}
