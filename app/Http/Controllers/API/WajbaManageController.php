<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Photo;
use App\Wajba;
use App\Review;
use App\Date;
use App\Time;
use App\Booking;
use App\Notification;
use App\User;
use App\Host;

use App\Events\WajbaEvent;
use Illuminate\Support\Facades\Auth;
use Validator;
use Image;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Wajba as WajbaResource;
use App\Http\Resources\Date as DateResource;
use App\Http\Resources\Booking as BookingResource;

class WajbaManageController extends Controller
{
    public function add_wajba(Request $request)
    {   
        $rules = [
            'place_category_id' => 'required',
            'food_category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'door_type' => 'required',
            'city' => 'required',
            'city_name' => 'required',
            'baseNumberOfSeats' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'experience_image' => 'required|image|mimes:jpeg,bmp,png|max:1024',
            'gallery_files.*' => 'image|mimes:jpeg,bmp,png|max:1024',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 422);
        }
        $input = $request->all();
        $host_id = Auth::user()->host->id;
        $input['host_id'] = $host_id;
        $input['status_id'] = 2;
        unset($input['experience_image']);
        unset($input['gallery_files']);
        unset($input['days']);
        unset($input['from_time']);
        unset($input['to_time']);
        $wajba = Wajba::create($input);

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
        DB::transaction(function () use($request, $wajba, $dates) {
            for ($i=0; $i < count($dates); $i++) { 
                Date::create([
                    'wajba_id' => $wajba->id,
                    'date' => $dates[$i],
                    'numberOfSeatsAvailable' => $request->get('baseNumberOfSeats'),
                ]);
                
            }
        });

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

        return response(
            [
                "success" => new WajbaResource($wajba)
            ]
            , 200);
    }

    public function edit_wajba(Request $request)
    {
        $rules = [
            'wajba_id' => 'required',
            'place_category_id' => 'required',
            'food_category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'door_type' => 'required',
            'city' => 'required',
            'city_name' => 'required',
            'baseNumberOfSeats' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];

        if ($request->hasFile('experience_image')) {
            $rules['experience_image'] = 'image|mimes:jpeg,bmp,png|max:1024';
        }
        if ($request->hasFile('gallery_files')) {
            $rules['gallery_files.*'] = 'image|mimes:jpeg,bmp,png|max:1024';
        }
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 422);
        }        
        $wajba_id = $request->get('wajba_id');
        if(Wajba::find($wajba_id)){
            $input = $request->all();
            $host_id = Auth::user()->host->id;
            $input['host_id'] = $host_id;
            // $input['status_id'] = 1;
            unset($input['wajba_id']);
            unset($input['days']);
            unset($input['from_time']);
            unset($input['to_time']);
            if($request->has('experience_image')){
                unset($input['experience_image']);
            }
            if($request->has('gallery_files')){
                unset($input['gallery_files']);
            }
            $wajba = Wajba::where('id', $wajba_id)->update($input);
            $wajba = Wajba::find($wajba_id);
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
                // dd($real_add_dates);
                if (!empty($real_add_dates)) {
                    DB::transaction(function () use($real_add_dates, $wajba, $request) {
                        foreach ($real_add_dates as $value) {
                            Date::create([
                                'wajba_id' => $wajba->id,
                                'date' => $value,
                                'numberOfSeatsAvailable' => $request->get('baseNumberOfSeats'),
                            ]);
                        }
                    });
                }
                if(!empty($real_remove_dates)){
                    foreach ($real_remove_dates as $value) {
                        if (Date::where('wajba_id', $wajba->id)->where('date', $value)->first()->bookings()->exists()) {
                            return back()->withSuccess('The dates have some bookings. so, you can\'t delete some dates.');
                        }else{
                            Date::where('wajba_id', $wajba->id)->where('date', $value)->delete();
                        }
                    }
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
            
            activity()->performedOn(Wajba::find($wajba_id))->log('updated');

            if(Wajba::find($wajba_id)->bookings()->exists()){
                $user_ids = Wajba::find($wajba_id)->bookings()->get()->pluck('user_id');
                $title = Wajba::find($wajba_id)->title;
                $message_en = "The wajba " . $title . " updated at " . date('Y-m-d H:i:s') . ".";
                $message_ar = "The wajba " . $title . " updated at " . date('Y-m-d H:i:s') . ".(AR)";
                // $link = "/admin/wajba_detail/" . $wajba->id;
                foreach ($user_ids as $item) {
                    $notify = Notification::create([
                        'type'  => 'update_wajba',
                        'comment_en' => $message_en,
                        'comment_ar' => $message_ar,
                        // 'link' => $link ,
                        'user_id' => $item,
                    ]);
                    
                    event(new WajbaEvent($item, $message_en));
                }
            }

            return response([
                'success' => new WajbaResource(Wajba::find($wajba_id))
            ], 200);
        }else{
            return response([
                'error' => "Can't find the wajba" 
            ], 200);
        }
    }

    public function delete_wajba(Request $request)
    {
        $wajba_id = $request->get('wajba_id');
        $wajba = Wajba::find($wajba_id);
        $wajba->photo()->delete();

        if(Wajba::find($wajba_id)->bookings()->exists()){
            $user_ids = Wajba::find($wajba_id)->bookings()->get()->pluck('user_id');
            $title = Wajba::find($wajba_id)->title;
            $message_en = "The wajba " . $title . " deleted at " . date('Y-m-d H:i:s') . ".";
            $message_ar = "The wajba " . $title . " deleted at " . date('Y-m-d H:i:s') . ".(AR)";
            // $link = "/admin/wajba_detail/" . $wajba->id;
            foreach ($user_ids as $item) {
                $notify = Notification::create([
                    'type'  => 'delete_wajba',
                    'comment_en' => $message_en,
                    'comment_ar' => $message_ar,
                    // 'link' => $link ,
                    'user_id' => $item,
                ]);
                
                event(new WajbaEvent($item, $message_en));
            }
        }

        $wajba->delete();
        return response([
            'success' => 'success',
        ], 200);

    }

    public function wajba_status_change(Request $request)
    {
        $wajba_id = $request->get('wajba_id');
        $status_id = $request->get('status_id');
        $wajba = Wajba::find($wajba_id);
        $wajba->status_id = $status_id;
        $wajba->save();

        activity()->performedOn(Wajba::find($wajba_id))->withProperties(['status' => $wajba->status->type])->log('status_changed');

        $message_en = 'Your wajba "' . $wajba->title . '" is updated to ' . '"' . $wajba->status->type .'" at ' . date('Y-m-d H:i:s'). '.';
        $message_ar = 'Your wajba "' . $wajba->title . '" is updated to ' . '"' . $wajba->status->type .'" at ' . date('Y-m-d H:i:s'). '.(AR)';
        Notification::create([
            'type'  => 'wajba_status_change',
            'comment_en' => $message_en,
            'comment_ar' => $message_ar,
            'user_id' => $wajba->host->user->id,
        ]);
        event(new WajbaEvent($wajba->host->user->id, $message_en));

        return response([
            'success' => 'success',
        ], 200);

    }

    public function get_wajbas(Request $request)
    {
        $mod = new Wajba();
        if($request->has('keyword') && $request->get('keyword') != ''){
            $keyword = $request->get('keyword');
            $mod = $mod->where('description', 'LIKE', "%$keyword%");
        }
        if($request->has('place_category_id') && $request->get('place_category_id') != ''){
            $mod = $mod->where('place_category_id', $request->get('place_category_id'));
        }
        if($request->has('food_category_id') && $request->get('food_category_id') != ''){
            $mod = $mod->where('food_category_id', $request->get('food_category_id'));
        }
        if($request->has('city_name') && $request->get('city_name') != ''){
            $mod = $mod->where('city_name', 'like', '%'.$request->get('city_name').'%');
        }
        $data = $mod->orderBy('created_at', 'desc')->where('status_id', 1)->paginate(10);
        return WajbaResource::collection($data);

    // $allUsers = collect(DB::select(DB::raw("SELECT id, languages, interests, blacklist,
    // ( 6371 * acos( cos( radians(" . $lat . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $lng . ") ) + sin( radians(" . $lat .") ) * sin( radians(lat) ) ) ) AS distance FROM users ORDER BY distance")));

    }

    public function get_wajba_by_id(Request $request)
    {
        if(!Wajba::find($request->wajba_id)){
            return response([
                'error' => "Can't find the wajba"
            ], 422);
        }
        return new WajbaResource(Wajba::find($request->wajba_id));
    }

    public function get_wajba_pending(Request $request)
    {
        return WajbaResource::collection(Wajba::where('status_id', 2)->get());
    }

    public function rate_wajba(Request $request)
    {
        if(Auth::user()->bookings()->where('wajba_id', $request->wajba_id)->exists()){
            $input = array();
            $input['user_id'] = Auth::id();
            $input['wajba_id'] = $request->get('wajba_id');
            $input['rate'] = $request->get('rate');
            $input['comment'] = $request->get('comment');
            Review::create($input);
            $booking = Auth::user()->bookings()->where('wajba_id', $request->wajba_id)->first();
            $booking->is_rated = 1;
            $booking->save();
            return response()->json(['success' => 'Ok'], 200);

        }else{
            return response([
                'error' => 'error'
            ], 422);
        }
    }

    public function get_date_time(Request $request)
    {
        $wajba_id = $request->get('wajba_id');
        $wajba = Wajba::find($wajba_id);
        // return DateResource::collection(Wajba::find($wajba_id)->dates);
        return response()->json([
            'time' => $wajba->time,
            'date' => $wajba->dates
        ]);
    }

    public function get_my_wajbas(Request $request)
    {
        return WajbaResource::collection(Auth::user()->host->wajbas);
    }

    public function get_wajba_bookings(Request $request)
    {
        return BookingResource::collection(Wajba::find($request->get('wajba_id'))->bookings);
    }

    public function get_top_city(Request $request)
    {
        if (Wajba::get()) {
            $sorted = Wajba::select('city_name')->where('status_id', 1)->get()->sortByDesc(function ($wajba) {
                return $wajba->count_city();
            });
            return response()->json(($sorted->unique('city_name')->take(10))->values()->all());
        }
    }

    public function get_top_place(Request $request)
    {
        if (Wajba::get()) {
            $sorted = Wajba::with(['place_category'])->where('status_id', 1)->get()->sortByDesc(function ($wajba) {
                return $wajba->count_place();
            });
            $place = array();
            $result = ($sorted->unique('place_category_id')->take(10))->values()->all();
            foreach ($result as $value) {
                array_push($place, $value->place_category->name);
            }
            return response()->json($place);
        }
    }

    public function get_top_food(Request $request)
    {
        if (Wajba::get()) {
            $sorted = Wajba::with(['food_category'])->where('status_id', 1)->get()->sortByDesc(function ($wajba) {
                return $wajba->count_food();
            });
            $food = array();
            $result = ($sorted->unique('food_category_id')->take(10))->values()->all();
            foreach ($result as $value) {
                array_push($food, $value->food_category->name);
            }
            return response()->json($food);
        }
    }

    public function add_date(Request $request)
    {
        $wajba_id = $request->get('wajba_id');
        $date = $request->get('date');
        $date = Date::create([
            'wajba_id' => $wajba_id,
            'date' => $date,
        ]);

        return response([
            'wajba_id' => $wajba_id,
            'date_id' => $date->id,
        ], 200);
    }

    public function edit_date(Request $request)
    {
        $wajba_id = $request->get('wajba_id');
        $date_id = $request->get('date_id');
        $date = $request->get('new_date');
        $date = Date::find($date_id)->update([
            'wajba_id' => $wajba_id,
            'date' => $date,
        ]);

        return response([
            'wajba_id' => $wajba_id,
            'date_id' => $date_id,
        ], 200);
    }

    public function delete_date(Request $request)
    {
        $date_id = $request->get('date_id');
        $date = Date::findOrFail($date_id);
        $date->delete();
        return response([
            'success' => 'success'
        ], 200);
    }

    public function add_time(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fromTime' => 'required',
            'toTime' => 'required',
            'baseNumberOfSeats' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 422);
        }

        $time = Time::create([
            'date_id' => $request->get('date_id'),
            'fromTime' => $request->get('fromTime'),
            'toTime' => $request->get('toTime'),
            'baseNumberOfSeats' => $request->get('baseNumberOfSeats'),
            'numberOfSeatsAvailable' => $request->get('baseNumberOfSeats')
        ]);
        return response([
            'date_id' => $request->get('date_id'),
            'time_id' => $time->id,
        ], 200);
    }

    public function edit_time(Request $request)
    {
        $time_id = $request->get('time_id');
        $fromTime = $request->get('fromTime');
        $date = $request->get('new_date');
        $numberOfSeatsAvailable = $request->get('baseNumberOfSeats');
        $total = 0;
        if(Booking::where('time_id', $time_id)->exists()){
            $booking = Booking::where('time_id', $time_id)->get();
            foreach ($booking as $item) {
                $total += $item->numberOfFemales;
                $total += $item->numberOfMales;
            }
            $numberOfSeatsAvailable -= $total;
        }
        $time = Time::find($time_id);
        $time->fromTime = $request->get('fromTime');
        $time->toTime = $request->get('toTime');
        $time->baseNumberOfSeats = $request->get('baseNumberOfSeats');
        $time->numberOfSeatsAvailable = $numberOfSeatsAvailable;

        $time->save();

        return response([
            'date_id' => $request->get('date_id'),
            'time_id' => $time_id,
        ], 200);
    }

    public function delete_time(Request $request)
    {
        $time_id = $request->get('time_id');
        $time = Time::findOrFail($time_id);
        $time->delete();
        return response([
            'success' => 'success'
        ], 200);
    }

    
}
