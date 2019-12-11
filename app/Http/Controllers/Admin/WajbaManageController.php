<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Wajba;
use App\PlaceCategory;
use App\FoodCategory;
use App\Notification;
use App\Status;
use Mail;

class WajbaManageController extends Controller
{

    protected $title;
    protected $place_id;
    protected $food_id;
    protected $door_type;
    protected $pagesize;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware(['auth', 'admin']);
        $this->title = '';
        $this->place_id = '';
        $this->food_id = '';
        $this->door_type = '';
        $this->pagesize = '';
    }

    protected function search_query($request)
    {
        if ($request->has('pagesize')) {
            $this->pagesize = $request->get('pagesize');
            if($this->pagesize == 'all'){
                $this->pagesize = Wajba::all()->count();
            }
        }else{
            $this->pagesize = 10;
        }
        
        $mod = new Wajba();
        if($request->get('title') != ''){
            $this->title = $request->get('title');
            $mod = $mod->where('title', 'LIKE', '%'.$this->title.'%');
        }
        if($request->get('place_id') != ''){
            $this->place_id = $request->get('place_id');
            $mod = $mod->where('place_category_id', $this->place_id);
        }
        if($request->get('food_id') != ''){
            $this->food_id = $request->get('food_id');
            $mod = $mod->where('food_category_id', $this->food_id);
        }
        if($request->get('door_type') != ''){
            $this->door_type = $request->get('door_type');
            $mod = $mod->where('door_type', $this->door_type);
        }
        
        return $mod;
    }

    public function index(Request $request)
    {
        session(['page' => 'all_exp']);
        $place_category = PlaceCategory::all();
        $food_category = FoodCategory::all();
        $mod = $this->search_query($request);
        $title = $this->title;
        $place_id = $this->place_id;
        $food_id = $this->food_id;
        $door_type = $this->door_type;
        $pagesize = $this->pagesize;
        $wajba = $mod->orderBy('created_at', 'desc')->with(['place_category', 'food_category', 'host'])->paginate($pagesize);
        return view('admin.wajba_manage.index', compact('wajba', 'title', 'place_id', 'food_id', 'door_type', 'pagesize', 'place_category', 'food_category'));
    }

    public function wajba_manage_approve(Request $request)
    {
        session(['page' => 'approved_exp']);
        $place_category = PlaceCategory::all();
        $food_category = FoodCategory::all();
        $mod = $this->search_query($request);
        $title = $this->title;
        $place_id = $this->place_id;
        $food_id = $this->food_id;
        $door_type = $this->door_type;
        $pagesize = $this->pagesize;
        $wajba = $mod->where('status_id', 1)->orderBy('created_at', 'desc')->with(['place_category', 'food_category', 'host'])->paginate($pagesize);
        return view('admin.wajba_manage.approve', compact('wajba', 'title', 'place_id', 'food_id', 'door_type', 'pagesize', 'place_category', 'food_category'));
    }

    public function wajba_manage_pending(Request $request)
    {
        session(['page' => 'non_exp']);
        $place_category = PlaceCategory::all();
        $food_category = FoodCategory::all();
        $mod = $this->search_query($request);
        $title = $this->title;
        $place_id = $this->place_id;
        $food_id = $this->food_id;
        $door_type = $this->door_type;
        $pagesize = $this->pagesize;
        $wajba = $mod->where('status_id', 2)->orderBy('created_at', 'desc')->with(['place_category', 'food_category', 'host'])->paginate($pagesize);
        return view('admin.wajba_manage.pending', compact('wajba', 'title', 'place_id', 'food_id', 'door_type', 'pagesize', 'place_category', 'food_category'));
    }

    public function wajba_manage_reject(Request $request)
    {
        session(['page' => 'reject_exp']);
        $place_category = PlaceCategory::all();
        $food_category = FoodCategory::all();
        $mod = $this->search_query($request);
        $title = $this->title;
        $place_id = $this->place_id;
        $food_id = $this->food_id;
        $door_type = $this->door_type;
        $pagesize = $this->pagesize;
        $wajba = $mod->where('status_id', 3)->orderBy('created_at', 'desc')->with(['place_category', 'food_category', 'host'])->paginate($pagesize);
        return view('admin.wajba_manage.reject', compact('wajba', 'title', 'place_id', 'food_id', 'door_type', 'pagesize', 'place_category', 'food_category'));
    }

    public function wajba_detail($id)
    {
        $wajba = Wajba::with(['photos'])->find($id);
        return view('admin.wajba_manage.detail', compact('wajba'));
    }

    public function wajba_status_change(Request $request)
    {
        $wajba_id = $request->get('wajba_id');
        $status_id = $request->get('status_id');

        // $status = Status::find('status_id')->type;
        $host_name = Wajba::find($wajba_id)->host->user->full_name;
        $host_email = Wajba::find($wajba_id)->host->user->email;
        $wajba_title = Wajba::find($wajba_id)->title;
        $data = array('status_id'=>$status_id, 'host_name'=>$host_name, 'host_email'=>$host_email, 'wajba_title'=>$wajba_title);
        Mail::send('emails.wajba_status', $data, function($message) use($host_email, $host_name) {
            $message->to($host_email, $host_name)->subject('Experience Status');
        });

        Wajba::find($wajba_id)->update([
            'status_id' => $status_id,
        ]);
        return back();
    }

    public function mark_read()
    {
        if(Notification::where('is_new', 1)->exists()){
            Notification::where('is_new', 1)->update([
                'is_new' => 0
            ]);
            return 'success';            
        }else{
            return 'error';
        }
    }
}
