<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Mail;

class UserManageController extends Controller
{
    protected $fullName;
    protected $mobile;
    protected $email;
    protected $pagesize;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
        $this->fullName = '';
        $this->mobile = '';
        $this->email = '';
        $this->pagesize = '';
    }

    protected function search_query($request)
    {
        if ($request->has('pagesize')) {
            $this->pagesize = $request->get('pagesize');
            if($this->pagesize == 'all'){
                $this->pagesize = User::all()->count();
            }
        }else{
            $this->pagesize = 10;
        }
        
        $mod = new User();
        // if($request->get('fullName') != ''){
        //     $this->fullName = $request->get('fullName');
        //     $mod = $mod->where('fullName', 'LIKE', '%'.$this->fullName.'%');
        // }
        if($request->get('mobile') != ''){
            $this->mobile = $request->get('mobile');
            $mod = $mod->where('mobile', $this->mobile);
        }
        if($request->get('email') != ''){
            $this->email = $request->get('email');
            $mod = $mod->where('email', $this->email);
        }
        return $mod;
    }

    public function index(Request $request)
    {
        $mod = $this->search_query($request);
        // $fullName = $this->fullName;
        $mobile = $this->mobile;
        $email = $this->email;
        $pagesize = $this->pagesize;
        session(['page' => 'all_user']);
        $user = $mod->whereIn('role_id', [2, 3])->orderBy('created_at', 'desc')->with(['role'])->paginate($pagesize);
        return view('admin.user_manage.index', compact('user', 'mobile', 'email', 'pagesize'));
    }

    public function user_manage_host(Request $request)
    {
        $mod = $this->search_query($request);
        // $fullName = $this->fullName;
        $mobile = $this->mobile;
        $email = $this->email;
        $pagesize = $this->pagesize;
        session(['page' => 'host_user']);
        $user = $mod->where('role_id', 2)->orderBy('created_at', 'desc')->with(['host'])->paginate($pagesize);
        return view('admin.user_manage.host', compact('user', 'mobile', 'email', 'pagesize'));
    }

    public function user_manage_guest(Request $request)
    {
        $mod = $this->search_query($request);
        // $fullName = $this->fullName;
        $mobile = $this->mobile;
        $email = $this->email;
        $pagesize = $this->pagesize;
        session(['page' => 'guest_user']);
        $user = $mod->where('role_id', 3)->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('admin.user_manage.guest', compact('user', 'mobile', 'email', 'pagesize'));
    }

    public function user_detail($id)
    {
        $user = User::find($id);
        $role = $user->role->type;
        if($role == 'host'){
            return view('admin.user_manage.detail_host', compact('user'));
        }else if($role == 'guest'){
            return view('admin.user_manage.detail_guest', compact('user'));
        }else{
            return view('errors.404');
        }
    }

    public function user_status_change(Request $request)
    {
        $user_id = $request->get('user_id');
        $status_id = $request->get('status_id');
        User::find($user_id)->update([
            'status_id' => $status_id,
        ]);
        return back();
    }

    public function host_status_change($id)
    {
        $host_status = User::find($id)->host->status;
        if($host_status){
            $host_status = 0;
        }else{
            $host_status = 1;
        }
        User::find($id)->host()->update([
            'status' => $host_status,
        ]);

        $user = User::find($id);
        $user_email = $user->email;
        $user_name = $user->full_name;


        $data = array('status_id'=>$host_status, 'host_name'=>$user_name);

        Mail::send('emails.host_status', $data, function($message) use($user_email, $user_name) {
            $message->to($user_email, $user_name)->subject('Host Status');
        });

        return back();
    }
    
}
