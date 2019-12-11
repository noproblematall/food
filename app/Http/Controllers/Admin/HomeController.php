<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Photo;
use App\User;
use App\FoodCategory;
use App\PlaceCategory;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        session(['page' => 'home']);        
        return view('admin.dashboard');
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

    public function change_profile(Request $request)
    {
        $user = Auth::user();
        if($request->get('firstName') != ''){
            $user->firstName = $request->get('firstName');
        }
        if($request->get('lastName') != ''){
            $user->lastName = $request->get('lastName');
        }
        if($request->get('mobile') != ''){
            $user->mobile = $request->get('mobile');
        }
        if($request->get('email') != ''){
            $user->email = $request->get('email');
        }
        if($request->hasfile('photo')){
            $fileName = time() . '.' . request()->photo->getClientOriginalExtension();
            request()->photo->move(public_path('img/avatar'),$fileName);
            $url = 'img/avatar/' . $fileName;
            Photo::updateOrCreate(['photoable_id' => $user->id, 'photoable_type' => 'App\User'], ['url' => $url]);
        }
        $user->update();
        return [
            'success' => 'success'
        ];
    }    

    public function setting()
    {
        session(['page' => 'set']);
        $place_category = PlaceCategory::orderBy('name', 'asc')->get();
        $food_category = FoodCategory::orderBy('name', 'asc')->get();
        return view('admin.setting', compact('place_category', 'food_category'));
    }    

    public function add_place(Request $request)
    {
        $request->validate([
            'new_place' => 'required',
        ]);
        PlaceCategory::create([
            'name' => $request->get('new_place'),
        ]);
        return back()->withSuccess('Added Successfully.');
    }

    public function delete_place(Request $request)
    {
        PlaceCategory::where('id', $request->get('place_id'))->delete();
        return back()->withSuccess('Deleted Successfully.');
    }

    public function add_food(Request $request)
    {
        $request->validate([
            'new_food' => 'required',
        ]);
        FoodCategory::create([
            'name' => $request->get('new_food'),
        ]);
        return back()->withSuccess('Added Successfully.');
    }

    public function delete_food(Request $request)
    {
        FoodCategory::where('id', $request->get('food_id'))->delete();
        return back()->withSuccess('Deleted Successfully.');
    }

    
}
