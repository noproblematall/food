<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Booking;
use App\Payment;

class BookingManageController extends Controller
{

    protected $pagesize;
    protected $payment_status;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware(['auth', 'admin']);
        $this->pagesize = '';
        $this->payment_status = '';
    }

    protected function search_query($request)
    {
        if($request->has('pagesize')) {
            $this->pagesize = $request->get('pagesize');
            if ($this->pagesize == 'all') {
                $this->pagesize = Booking::all()->count();
            }
        }else{
            $this->pagesize = 10;
        }
        
        $mod = new Booking();
        if($request->has('payment_status') && $request->get('payment_status') != null){
            $this->payment_status = $request->get('payment_status');
            $payment_array = Payment::where('status', $this->payment_status)->pluck('id');
            $mod = $mod->whereIn('payment_id', $payment_array);
        }
        return $mod;
    }

    public function index(Request $request)
    {
        session(['page' => 'approve_booking']);
        $mod = $this->search_query($request);
        $pagesize = $this->pagesize;
        $payment_status = $this->payment_status;
        $booking = $mod->where('status_id', 1)->orderBy('created_at', 'desc')->with(['wajba', 'user'])->paginate($pagesize);
        return view('admin.booking_manage.index', compact('booking', 'pagesize', 'payment_status'));
    }

    public function booking_manage_pending(Request $request)
    {
        session(['page' => 'pending_booking']);
        $mod = $this->search_query($request);
        $pagesize = $this->pagesize;
        $payment_status = $this->payment_status;
        $booking = $mod->where('status_id', 2)->orderBy('created_at', 'desc')->with(['wajba', 'user'])->paginate($pagesize);
        return view('admin.booking_manage.pending', compact('booking', 'pagesize', 'payment_status'));
    }

    public function booking_manage_rejected(Request $request)
    {
        session(['page' => 'rejected_booking']);
        $mod = $this->search_query($request);
        $pagesize = $this->pagesize;
        $payment_status = $this->payment_status;
        $booking = $mod->where('status_id', 3)->orderBy('created_at', 'desc')->with(['wajba', 'user'])->paginate($pagesize);
        return view('admin.booking_manage.reject', compact('booking', 'pagesize', 'payment_status'));
    }

    public function booking_detail($id = null)
    {
        if($id == null){
            return back();
        }else{
            if (Booking::where('id', $id)->exists()) {
                $booking = Booking::find($id);
                return view('admin.booking_manage.detail', compact('booking'));
            }else{
                return view('errors.404');
            }
        }
    }
}
