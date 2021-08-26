<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;
use App\Host;
use App\Photo;
use App\Wajba;
use App\Date;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index()
    {
        $wajba = Wajba::with(['photos', 'host', 'dates', 'reviews'])->where('status_id', 1)->orderBy('created_at', 'desc')->paginate(6);
        return view('welcome', compact('wajba'));
    }

    public function come()
    {
        return view('come');
    }

    public function phone_confirm_login(Request $request)
    {
        $code = $request->get('code');
        $sid = $request->get('sid');
        $mobile = $request->get('mobile');

        $twilio_sid = config('app.twilio_sid');
        $token = config('app.twilio_token');
        $twilio = new Client($twilio_sid, $token);
        $verification_check = $twilio->verify->v2->services($sid)->verificationChecks->create($code, array("to" => $mobile));
        if($verification_check->status == 'approved'){
            $user = User::where('mobile', $mobile)->first();
            Auth::login($user);
            // $twilio->verify->v2->services($request->get('sid'))->delete();
            return response(['success' => 'success'], 200);
        }else{
            // $twilio->verify->v2->services($request->get('sid'))->delete();
            return response(['error' => $verification_check->status], 400);
        }
    }

    public function wajba_detail($id)
    {
        
        if (Wajba::where('id', $id)->exists()) {
            $wajba = Wajba::with(['time'])->find($id);
            $food_id = $wajba->food_category_id;
            $similar_wajba = Wajba::where('food_category_id', $food_id)->where('id', '!=', $id)->where('status_id', 1)->get()->take(4);
            return view('wajba_detail', compact('wajba', 'similar_wajba'));
        }
    }

    public function about_us()
    {
        return view('about_us');
    }

    public function contact_us()
    {
        return view('contact_us');
    }

    public function terms()
    {
        return view('term_condition');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function faq()
    {
        return view('faq');
    }


    public function get_available(Request $request)
    {
        $date = $request->get('date');
        $wajba_id = $request->get('wajba_id');
        $available = Date::where('wajba_id', $wajba_id)->where('date', $date)->first()->numberOfSeatsAvailable;
        $date_id = Date::where('wajba_id', $wajba_id)->where('date', $date)->first()->id;
        return response([
            'available' => $available,
            'date_id' => $date_id,
        ]);
    }
}
