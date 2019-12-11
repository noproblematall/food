<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Cache;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'mobile';
    }

    public function logout(Request $request)
    {
        if(Auth::user()->role_id == 1){
            $flag = true;
        }else{
            $flag = false;
        }
        Cache::forget('user-is-online-' . Auth::user()->id);
        $this->guard()->logout();

        $request->session()->invalidate();
        if($flag){
            return $this->loggedOut($request) ?: redirect('/admin');
        }else{
            return $this->loggedOut($request) ?: redirect('/');

        }

    }

    // public function authenticated(Request $request, $user) {

    // }
}
