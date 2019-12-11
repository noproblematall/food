<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;


class HistoryController extends Controller
{

    private $pagesize;

    public function __construct(){
        $this->middleware(['auth', 'admin']);
        $this->pagesize = '';
        // $this->payment_status = '';
    }

    protected function search_query($request)
    {
        if($request->has('pagesize')) {
            $this->pagesize = $request->get('pagesize');
            if ($this->pagesize == 'all') {
                $this->pagesize = Activity::all()->count();
            }
        }else{
            $this->pagesize = 10;
        }
        
        $mod = new Activity();
        
        return $mod;
    }

    public function index(Request $request)
    {
        session(['page' => 'history']);
        $mod = $this->search_query($request);
        $pagesize = $this->pagesize;
        $logs = $mod->orderBy('created_at', 'desc')->with(['causer', 'subject'])->paginate($pagesize);
        return view('admin.history', compact('logs', 'pagesize'));
    }
}
