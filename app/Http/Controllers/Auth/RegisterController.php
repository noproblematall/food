<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Host;
use App\Photo;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rule = array();
        if ($data['check'] == 'guest') {
            $rule = [
                'firstName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'city' => ['required', 'string'],
                'mobile' => ['required', 'unique:users'],
            ];
        }else if($data['check'] == 'host'){
            $data['nameId'] = '@'.$data['nameId'];
            $rule = [
                'firstName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'city' => ['required', 'string'],
                'mobile' => ['required', 'unique:users'],
                'nameId' => ['required', 'string', 'unique:hosts'],
                // 'photo' => ['required', 'image', 'mimes:jpeg,bmp,png', 'max:1024'],
                'aboutYou' => ['required'],
            ];
        }
        return Validator::make($data, $rule);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $data = $request->all();

        if ($data['check'] == 'guest') {
            $user = User::create([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'password' => Hash::make($data['password']),
                'city' => $data['city'],
                'gender' => $data['gender']
            ]);
        }else if($data['check'] == 'host'){
            $host = Host::create([
                'nameId' => '@'.$data['nameId'],
                'aboutYou' => $data['aboutYou'],
                'status' => 1,
            ]);

            $user = User::create([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'password' => Hash::make($data['password']),
                'city' => $data['city'],
                'gender' => $data['gender'],
                'host_id' => $host->id,
                'role_id' => 2,
            ]); 

            if($request->hasfile('photo')){
                $fileName = time() . '.' . request()->photo->getClientOriginalExtension();
                request()->photo->move(public_path('img/avatar'),$fileName);
                $url = 'img/avatar/' . $fileName;
                Photo::create([
                    'url' => $url,
                    'photoable_id' => $user->id,
                    'photoable_type' => User::class,
                ]);
            }
        }

        event(new Registered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
    }
}
