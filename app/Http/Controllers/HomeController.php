<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Photo;
use App\Host;
use Validator;
use App\User;
use App\PlaceCategory;
use App\FoodCategory;
use App\Wajba;
use App\Events\WajbaEvent;
use App\Notification;
use App\Time;
use App\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Image;


class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->role->type;
        if ($role == 'admin') {
            return redirect()->route('admin.home');
        }else {
            session(['side_bar' => 'profile']);
            $user = Auth::user();
            return view('home', compact('user'));
        }
    }

    public function profile_edit(Request $request)
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

        $request->validate($validation_array, [
            'photo.max' => 'Please make sure the image size is less than 1MB'
        ]);

        $data = $request->all();
        if(array_key_exists('mobile', $data)){
            unset($data['mobile']);
        }
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

        return back();
    }


    public function get_notify()
    {
        session(['side_bar' => 'get_notify']);
        return view('my_notify');
    }

    public function become_host()
    {
        if (auth()->user()->role_id == 2) {
            return back();
        } else {
            session(['side_bar' => 'become_host']);
            return view('become_host');
        }
        
    }

    public function become_host_save(Request $request)
    {
        $user = Auth::user();
        $validate_array = [
            'nameId' => 'required|unique:hosts',
            'aboutYou' => 'required',
        ];
        if(!$user->photo){
            $validate_array['photo'] = 'required|image';
        }
        
        $validate_input = $request->all();
        $validate_input['nameId'] = '@'.$validate_input['nameId'];
        Validator::make($validate_input, $validate_array)->validate();

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
            $url = 'img/avatar/' . $fileName;
            Photo::create([
                'url' => $url,
                'photoable_id' => $user->id,
                'photoable_type' => User::class,
            ]);
        }
        return redirect()->route('home');
        // return redirect()->route('home')->withSuccess('Your host is pending now. Please wait for 1 ~ 2 business days.');
    }

    public function check_id(Request $request)
    {
        $data = $request->get('data');
        $unique = Host::where('nameId', '@'.$data)->exists();
        if ($unique) {
            return 'no';
        }else{
            return 'ok';
        }
    }
    

    public function get_experience()
    {
        session(['side_bar' => 'get_experience']);
        $wajbas = Auth::user()->host->wajbas;
        return view('experience', compact('wajbas'));
    }

    public function new_experience()
    {
        $food = FoodCategory::all();
        $place = PlaceCategory::all();
        return view('new_experience', compact('food', 'place'));
    }

    public function create_hihome(Request $request)
    {
        $request->validate([
            'place_category' => 'required',
            'food_category' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'door_type' => 'required',
            'city' => 'required',
            'city_name' => 'required',
            'seat' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            // 'days' => 'required',
            'lat' => 'required',
            'lot' => 'required',
            'experience_image' => 'required|image|mimes:jpeg,bmp,png|max:1024',
            // 'banner_file' => 'required|image|mimes:jpeg,bmp,png|max:1024',
            'gallery_files.*' => 'image|mimes:jpeg,bmp,png|max:1024',
        ], [
            'experience_image.max' => 'Please make sure the image size is less than 1MB',
            // 'banner_file.max' => 'Please make sure the image size is less than 1MB',
            'gallery_files.*.max' => 'Please make sure the image size is less than 1MB'
        ]);

        $wajba = Wajba::create([
            'host_id' => Auth::user()->host->id,
            'status_id' => 2,
            'place_category_id' => $request->place_category,
            'food_category_id' => $request->food_category,
            'title' => $request->get('title'),
            'price' => $request->get('price'),
            'description' => $request->get('description'),
            'door_type' => $request->door_type,
            'healthConditionsAndWarnings' => $request->get('health'),
            'city' => $request->get('city'),
            'city_name' => $request->get('city_name'),
            'latitude' => $request->lat,
            'longitude' => $request->lot,
            'baseNumberOfSeats' => $request->get('seat')
        ]);

        // if ($request->get('city_name')) {
        //     $wajba->city_name = $request->get('city_name');
        //     $wajba->save();
        // }

        Time::create([
            'wajba_id' => $wajba->id,
            'fromTime' => $request->get('from_time'),
            'toTime' => $request->get('to_time'),
        ]);
        
        $dates = explode(",", $request->get('days'));
        for ($i=0; $i < count($dates); $i++) { 
            Date::create([
                'wajba_id' => $wajba->id,
                'date' => $dates[$i],
                // 'baseNumberOfSeats' => $request->get('seat'),
                'numberOfSeatsAvailable' => $request->get('seat'),
            ]);
            
        }
        

        if ($request->hasFile('experience_image')) {
            $fileName = uniqid() . '.' . $request->file('experience_image')->getClientOriginalExtension();
            $request->file('experience_image')->move(public_path('frontend/imgs/homepage'), $fileName);
            $url = 'frontend/imgs/homepage/' . $fileName;
            $url_banner = 'frontend/imgs/bannerpage/' . $fileName;
            $img = Image::make($url)->fit(500, 375, function($constraint) {
                $constraint->upsize();
            });
            $img_banner = Image::make($url)->fit(1920, 500, function($constraint) {
                $constraint->upsize();
            });
            $img->save($url);
            $img_banner->save($url_banner);

            Photo::create([
                'url' => $url,
                'photoable_id' => $wajba->id,
                'photoable_type' => Wajba::class,
            ]);
            Photo::create([
                'url' => $url_banner,
                'type' => 1,
                'photoable_id' => $wajba->id,
                'photoable_type' => Wajba::class,
            ]);
        }
        // if ($request->hasFile('banner_file')) {
        //     $fileName = uniqid() . '.' . $request->file('banner_file')->getClientOriginalExtension();
        //     $request->file('banner_file')->move(public_path('frontend/imgs/bannerpage'), $fileName);
        //     $url = 'frontend/imgs/bannerpage/' . $fileName;
        //     // $img = Image::make($url)->resize(1920, 500);
        //     // $img->save($url);

        //     Photo::create([
        //         'url' => $url,
        //         'type' => 1,
        //         'photoable_id' => $wajba->id,
        //         'photoable_type' => Wajba::class,
        //     ]);
        // }

        if($request->hasfile('gallery_files'))
        {
            DB::transaction(function () use($request, $wajba) {
                $i = 0;
                foreach($request->file('gallery_files') as $photo)
                {
                    $i++;
                    $filename = (uniqid() . $i) . '.' . $photo->getClientOriginalExtension();
                    $photo->move(public_path('frontend/imgs/gallery'), $filename);
                    $url = 'frontend/imgs/gallery/' . $filename;
                    $img = Image::make($url)->fit(1920, 1000, function($constraint) {
                        $constraint->upsize();
                    });
                    // $img = Image::make($url)->resize(1920, 500);
                    $img->save($url);
                    Photo::create([
                        'url' => $url,
                        'type' => 2,
                        'photoable_id' => $wajba->id,
                        'photoable_type' => Wajba::class,
                    ]);
                }

            });
        }

        $name = Auth::user()->full_name;
        $message_en = 'Host <strong>'. $name .'</strong> created new food <strong>"' . $wajba->title . '"</strong> at ' . date('Y-m-d H:i:s'). '.';
        $message_ar = 'Host '. $name .' created new food "' . $wajba->title . '" at ' . date('Y-m-d H:i:s') . '.(AR)';
        $link = "/admin/wajba_detail/" . $wajba->id;
        $notify = Notification::create([
            'type'  => 'new_wajba',
            'comment_en' => $message_en,
            'comment_ar' => $message_ar,
            'link' => $link ,
            'user_id' => 1,
        ]);
        
        event(new WajbaEvent(1, $message_en, $link));

        return redirect()->route('get_experience')->withSuccess('Your experience is pending now. Please wait for 1 ~ 2 business days.');
    }

    public function experience_edit($id)
    {
        $food = FoodCategory::all();
        $place = PlaceCategory::all();
        $wajba = Wajba::with(['time', 'dates'])->find($id);
        return view('experience_edit', compact('wajba', 'food', 'place'));
    }

    public function edit_hihome(Request $request)
    {
        $rules = [
            'place_category' => 'required',
            'food_category' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'door_type' => 'required',
            'city' => 'required',
            'seat' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            // 'days' => 'required',
            'lat' => 'required',
            'lot' => 'required',
        ];

        if ($request->hasFile('experience_image')) {
            $rules['experience_image'] = 'image|mimes:jpeg,bmp,png|max:1024';
        }

        // if ($request->hasFile('banner_file')) {
        //     $rules['banner_file'] = 'image|mimes:jpeg,bmp,png|max:1024';
        // }

        if ($request->hasFile('gallery_files')) {
            $rules['gallery_files.*'] = 'image|mimes:jpeg,bmp,png|max:1024';
        }

        $request->validate($rules, [
            'experience_image.max' => 'Please make sure the image size is less than 1MB',
            // 'banner_file.max' => 'Please make sure the image size is less than 1MB',
            'gallery_files.*.max' => 'Please make sure the image size is less than 1MB'
        ]);

        $wajba = Wajba::find($request->wajba_id);
        if (!$wajba) {
            return redirect()->route('get_experience')->withErrors('The experience is not exist.');
        }
        $wajba->place_category_id = $request->place_category;
        $wajba->food_category_id = $request->food_category;
        $wajba->title = $request->get('title');
        $wajba->description = $request->get('description');
        $wajba->price = $request->get('price');
        $wajba->door_type = $request->door_type;
        $wajba->city = $request->get('city');
        $wajba->latitude = $request->lat;
        $wajba->longitude = $request->lot;
        $wajba->city_name = $request->get('city_name');
        $wajba->save();

        $wajba->time()->update([
            'fromTime' => $request->get('from_time'),
            'toTime' => $request->get('to_time')
        ]);

        if ($request->get('days') != '') {
            $new_dates = explode(",", $request->get('days'));
            $old_dates = array();
            if ($wajba->dates()->whereDate('date', '>=', date('Y-m-d'))->exists()) {
                $old_dates = $wajba->dates()->whereDate('date', '>=', date('Y-m-d'))->get()->pluck('date')->toArray();
            }
            $real_remove_dates = array_diff($old_dates, $new_dates);
            $real_add_dates = array_diff($new_dates, $old_dates);
            // dd($real_remove_dates);
            if (!empty($real_add_dates)) {
                DB::transaction(function () use($real_add_dates, $wajba, $request) {
                    foreach ($real_add_dates as $value) {
                        Date::create([
                            'wajba_id' => $wajba->id,
                            'date' => $value,
                            'numberOfSeatsAvailable' => $request->get('seat'),
                        ]);
                    }
                });
            }
            if(!empty($real_remove_dates)){
                // DB::transaction(function () use($real_remove_dates, $wajba) {
                    foreach ($real_remove_dates as $value) {
                        if (Date::where('wajba_id', $wajba->id)->where('date', $value)->first()->bookings()->exists()) {
                            return back()->withSuccess('The dates have some bookings. so, you can\'t delete some dates.');
                        }else{
                            Date::where('wajba_id', $wajba->id)->where('date', $value)->delete();
                        }
                    }
                // });
            }
        }else{
            // if ($wajba->dates()->whereDate('date', '>=', date('Y-m-d'))->exists()) {
            //     $old_dates = $wajba->dates()->whereDate('date', '>=', date('Y-m-d'))->delete();
            // }
        }

        if ($request->hasFile('experience_image')) {
            $fileName = uniqid() . '.' . $request->file('experience_image')->getClientOriginalExtension();
            $request->file('experience_image')->move(public_path('frontend/imgs/homepage'), $fileName);
            $url = 'frontend/imgs/homepage/' . $fileName;
            $url_banner = 'frontend/imgs/bannerpage/' . $fileName;
            $img = Image::make($url)->fit(500, 375, function($constraint) {
                $constraint->upsize();
            });
            $img_banner = Image::make($url)->fit(1920, 500, function($constraint) {
                $constraint->upsize();
            });
            $img->save($url);
            $img_banner->save($url_banner);

            $wajba->photos()->where('type', 0)->update([
                'url' => $url,
            ]);
            $wajba->photos()->where('type', 1)->update([
                'url' => $url_banner,
            ]);
        }

        // if ($request->hasFile('banner_file')) {
        //     $fileName = uniqid() . '.' . $request->file('banner_file')->getClientOriginalExtension();
        //     $request->file('banner_file')->move(public_path('frontend/imgs/bannerpage'), $fileName);
        //     $url = 'frontend/imgs/bannerpage/' . $fileName;
        //     // $img = Image::make($url)->resize(1920, 500);
        //     // $img->save($url);

        //     $wajba->photos()->where('type', 1)->update([
        //         'url' => $url,
        //     ]);
        // }

        if($request->hasfile('gallery_files'))
        {
            DB::transaction(function () use($request, $wajba) {
                $i = 0;
                foreach($request->file('gallery_files') as $photo)
                {
                    $i++;
                    $filename = (uniqid() . $i) . '.' . $photo->getClientOriginalExtension();
                    $photo->move(public_path('frontend/imgs/gallery'), $filename);
                    $url = 'frontend/imgs/gallery/' . $filename;
                    $img = Image::make($url)->fit(1920, 1000, function($constraint) {
                        $constraint->upsize();
                    });
                    // $img = Image::make($url)->resize(1920, 500);
                    $img->save($url);
                    Photo::create([
                        'url' => $url,
                        'type' => 2,
                        'photoable_id' => $wajba->id,
                        'photoable_type' => Wajba::class,
                    ]);
                }
            });
        }


        return redirect()->route('get_experience')->withSuccess('Your experience has updated successfully.');
    }

    public function gallery_delete(Request $request)
    {
        $id = $request->get('id');
        Photo::find($id)->delete();
        return response('ok');
    }

    public function change_password(Request $request)
    {
        $cur_password = $request['old_password'];
        $new_password = $request['new_password'];
        if(!Hash::check($cur_password, Auth::user()->password)){
            $errors = ['error' => 'The old password is incorrect.'];
            return $errors;
        }else{
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update([
                    'password' => Hash::make($new_password),
            ]);
            return [
                'success' => 'The password was changed successfully.'
            ];
        }
    }

}
