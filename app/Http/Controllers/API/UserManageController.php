<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use Authy\AuthyApi;

use App\User;
use App\Host;
use App\Photo;
use App\Wajba;
use App\Status;
use App\Http\Resources\Wajba as WajbaResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

use App\Http\Resources\User as UserResource;

class UserManageController extends Controller
{
    public function phone_verify(Request $request)
    {
        $mobile_number = $request->get('mobile');
        if(User::where('mobile', $mobile_number)->count() > 0){
            return response()->json(['error' => __('custom.unique', ['attribute' => 'mobile'])]);
        }else{
            $sid = config('app.twilio_sid');
            $token = config('app.twilio_token');
            $service_id = config('app.service_id');
            if($sid == '' || $token == ''){
                return response('Twilio setting error', 200);
            }else{
                try {
                    $twilio = new Client($sid, $token);
                    // $service = $twilio->verify->v2->services->create(config('app.name'));
                    
                    $verification = $twilio->verify->v2->services($service_id)->verifications->create($mobile_number, "sms");
                    return response([
                        'service_sid' => $service_id,
                        'mobile' => $mobile_number,
                        'status' => $verification->status
                    ], 200);
                } catch (RestException $e) {
                    if($e->getStatusCode() == 404) {
                        return false;
                    } else {
                        return response(
                            [
                                'error_message' => $e->getMessage(),
                                'error_code' => $e->getStatusCode()
                            ]
                        , 200);
                    }
                }
                
            }
        }

    }

    public function phone_confirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()], 422);
        }

        $sid = config('app.twilio_sid');
        $token = config('app.twilio_token');
        $twilio = new Client($sid, $token);
        $verification_check = $twilio->verify->v2->services($request->get('sid'))->verificationChecks->create($request->get('code'), array("to" => $request->get('mobile')));
        if($verification_check->status == 'approved'){
            // $success['mobile'] = $request->get('mobile');
            // $twilio->verify->v2->services($request->get('sid'))->delete();
            return response(['mobile' => $request->get('mobile')], 200);
        }else{
            // $twilio->verify->v2->services($request->get('sid'))->delete();
            return response(['error' => $verification_check->status], 200);
        }
    }

    // public function phone_confirm(Request $request)
    // {
    //     $this->validate($request, [
    //         'country_code' => 'required|string|max:3',
    //         'mobile' => 'required|string|max:10',
    //     ]);

    //     $api = config('app.twilio_authy_api');
    //     $authyApi = new AuthyApi($api);
    //     $phone_number =  $request->get('mobile');
    //     $country_code = $request->get('country_code');

    //     $response = $authyApi->phoneVerificationStart($phone_number, $country_code);
    //     if ($response->ok()) {
    //         return response()->json($response->message(), 200);
    //     } else {
    //         return response()->json((array)$response->errors(), 400);
    //     }
    // }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken(config('app.name'))->accessToken;
        $success['user_info'] = $user;
        return response(['success'=>$success], 200);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required',
            'password' => 'required'
        ]);
        if(Auth::attempt(['mobile' => request('mobile'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] = $user->createToken(config('app.name'))->accessToken;
            $success['user_info'] = $user->with(['host', 'status', 'photo'])->first()->toArray();
            return response()->json(['success' => $success], 200);
        }else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }

    }

    public function phone_verify_login(Request $request)
    {
        $mobile_number = $request->get('mobile');
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()], 200);
        }
        if(User::where('mobile', $mobile_number)->count() > 0){
            $twilio_sid = config('app.twilio_sid');
            $token = config('app.twilio_token');
            $service_id = config('app.service_id');
            if($twilio_sid == '' || $token == ''){
                return response('Twilio setting error', 200);
            }else{
                try {
                    $twilio = new Client($twilio_sid, $token);
                    // $service = $twilio->verify->v2->services->create(config('app.name'));
                    $verification = $twilio->verify->v2->services($service_id)->verifications->create($mobile_number, "sms");
                    return response([
                        'service_sid' => $service_id,
                        'mobile' => $mobile_number,
                        'status' => $verification->status
                    ], 200);
                } catch (RestException $e) {
                    if($e->getStatusCode() == 404) {
                        return false;
                    } else {
                        return response(
                            [
                                'error_message' => $e->getMessage(),
                                'error_code' => $e->getStatusCode()
                            ]
                        , 200);
                    }
                }
                
            }
            
        }else{
            return response([
                'error' => 'You are not registered user',
            ], 200);
        }
    }

    public function phone_confirm_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|size:6',
        ]);
        $code = $request->get('code');
        $sid = $request->get('sid');
        $mobile = $request->get('mobile');

        if($validator->fails()){
            return response(['error' => $validator->errors()], 422);
        }

        $twilio_sid = config('app.twilio_sid');
        $token = config('app.twilio_token');
        $twilio = new Client($twilio_sid, $token);
        $verification_check = $twilio->verify->v2->services($sid)->verificationChecks->create($code, array("to" => $mobile));
        if($verification_check->status == 'approved'){
            $user = User::with(['role', 'host', 'status', 'photo'])->where('mobile', $mobile)->first();
            Auth::login($user);
            $success['token'] = $user->createToken(config('app.name'))->accessToken;
            $success['user_info'] = $user->toArray();
            // $success['mobile'] = $request->get('mobile');
            // $twilio->verify->v2->services($request->get('sid'))->delete();
            return response(['success' => $success], 200);
        }else{
            // $twilio->verify->v2->services($request->get('sid'))->delete();
            return response(['error' => $verification_check->status], 200);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = __('auth.logout');
        return response(['success' => $response], 200);
    }

    public function host_become(Request $request)
    {
        $user = Auth::user();
        $validate_array = [
            'nameId' => 'required|unique:hosts',
            'aboutYou' => 'required',
        ];
        if(!$user->photo){
            $validate_array['photo'] = 'required|image|mimes:jpeg,bmp,png|max:1024';
        }
        $validate_input = $request->all();
        $validate_input['nameId'] = '@'.$validate_input['nameId'];
        $validator = Validator::make($validate_input, $validate_array);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 422);
        }
        // if(Host::where('nameId', '@'.$request->get('nameId'))->count() > 0){
        //     return response()->json(['error' => __('custom.unique', ['attribute' => 'nameId'])], 422);
        // }

        $input = array();
        $input['nameId'] = '@'.$request->get('nameId');
        $input['aboutYou'] = $request->get('aboutYou');
        $input['status'] = 1;
        $host = Host::create($input);

        $input = array();

        $user->update([
            'host_id' => $host->id,
            'role_id' => 2,
        ]);

        if($request->hasfile('photo')){
            $fileName = time() . '.' . request()->photo->getClientOriginalExtension();
            request()->photo->move(public_path('img/avatar'),$fileName);
            // $request->photo->storeAs('public/profile',$fileName);
            $url = 'img/avatar/' . $fileName;
            $photo = Photo::create([
                'url' => $url,
                'photoable_id' => $user->id,
                'photoable_type' => User::class,
            ]);
        }

        // return response()->json(['success'=>__('custom.pending', ['attribute' => 'account'])], 200);
        return response()->json(['success'=> 'success'], 200);
    }

    
    public function host_approve(Request $request)
    {
        $user_id = $request->get('user_id');
        if(User::find($user_id)->host()->exists()){
            User::find($user_id)->host()->update([
                'status' => true,
            ]);
            return response()->json(['success' => __('custom.update_host')], 200);
        }
        return response()->json(['error' => __('custom.error_host')], 422);
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 422);
        }
        $old_password = $request->get('old_password');
        $new_password = $request->get('new_password');
        if(!Hash::check($old_password, Auth::user()->password)){
            $errors = ['error' => 'The old password is incorrect.'];
            return response($errors);
        }else{
            Auth::user()->update([
                'password' => Hash::make($new_password),
            ]);
            
            return response([
                'success' => 'The password was changed successfully.'
            ], 200);
        }
    }

    public function user_all(Request $request)
    {
        if($request->has('role')){
            if($request->get('role') == 'host'){
                return UserResource::collection(User::where('role_id', '2')->get());
            }else if($request->get('role') == 'guest'){
                return UserResource::collection(User::where('role_id', '3')->get());
            }
        }else{
            return UserResource::collection(User::all());
            // return response(['data' => User::with(['role', 'host'])->get()], 200);
        }
    }

    public function users_non()
    {
        return UserResource::collection(User::where('status_id', 2)->get());
        // return response(Host::with(['user'])->where('status', false)->get(), 200);
    }

    public function user_details(Request $request)
    {
        if(User::where('id', $request->get('user_id'))->exists()){
            return new UserResource(User::find($request->get('user_id')));
        }else{
            return response()->json([
                'error'=>"Can't find the user"
            ]);
        }
    }

    public function user_status_change(Request $request)
    {
        $user_id = $request->get('user_id');
        $status_id = $request->get('status_id');
        User::find($user_id)->update([
            'status_id' => $status_id,
        ]);
        return response([
            'user_status' => Status::find($status_id)->type
        ], 200);
    }

    // public function host_status_change(Request $request)
    // {
    //     $user_id = $request->get('user_id');
    //     $host_status = User::find($user_id)->host->status;
    //     if($host_status){
    //         $host_status = 0;
    //     }else{
    //         $host_status = 1;
    //     }
    //     User::find($user_id)->host()->update([
    //         'status' => $host_status,
    //     ]);
    //     return response([
    //         'success' => $host_status
    //     ], 200);
    // }

    public function change_user_info(Request $request)
    {
        $user = Auth::user();
        $validation_array = [
            'firstName' => 'required',
            'lastName' => 'required',
        ];
        if($user->email != $request->get('email')){
            $validation_array['email'] = 'required|unique:users';
        }

        if($user->role->type == 'host'){
            $validation_array['aboutYou'] = 'required';
            if(!$user->photo){
                $validation_array['photo'] = 'required|image|mimes:jpeg,bmp,png|max:1024';
            }else{
                if($request->hasfile('photo')){
                    $validation_array['photo'] = 'image|mimes:jpeg,bmp,png|max:1024';
                }
            }
        }else{
            if($request->hasfile('photo')){
                $validation_array['photo'] = 'image|mimes:jpeg,bmp,png|max:1024';
            }
        }

        $validator = Validator::make($request->all(), $validation_array);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 422);
        }
        $data = $request->all();
        // unset($data['photo'])
        $user->update($data);
        if($user->role->type == 'host'){
            $user->host()->update([
                'aboutYou' => $request->get('aboutYou'),
            ]);
        }

        if($request->hasfile('photo')){
            $fileName = time() . '.' . request()->photo->getClientOriginalExtension();
            request()->photo->move(public_path('img/avatar'),$fileName);
            $url = 'img/avatar/' . $fileName;
            if($user->photo){
                $user->photo()->update([
                    'url' => $url
                ]);
            }else{
                Photo::create([
                    'url' => $url,
                    'photoable_id' => $user->id,
                    'photoable_type' => User::class,
                ]);
            }
        }
        $user = Auth::user()->with(['status', 'host', 'photo'])->first();
        return response([
            'success' => $user
        ], 200);

    }

    public function get_wajba_for_rate()
    {
        $wajba_id = Auth::user()->bookings()->where('is_rated', 0)->pluck('wajba_id');
        return WajbaResource::collection(Wajba::whereIn('id', $wajba_id)->get());
    }
}
