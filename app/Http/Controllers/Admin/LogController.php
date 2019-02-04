<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Log;
use Auth;
use App\User;
use Carbon\Carbon;

class LogController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$logs = Log::orderBy('created_at', 'desc')->get();
    	$logArr = [];
    	$x = 0;
    	foreach ($logs as $row) {
    		$user = User::find($row->user_id);
    		$role = $user->user_type == 1 ? 'Admin':'Content Manager';
    		$logArr[$x++] = [
    			'id' => $row->id,
    			'description' => '('.$role.')'.$user->name.' '.$row->action,
    			'created_at' => $row->created_at->toDayDateTimeString()
    		];
    	}

    	$logArr = json_decode(json_encode($logArr));

    	return view('log.index')
    		->with('logs', $logArr);
    }

    public function destroy($id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);
        
        $log = Log::find($id);
        $log->delete();

        // show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->route('log.index');
    }

    public function destroyAll() {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);
        
        Log::truncate();

        // show a success message
        \Alert::success('Items has been deleted.')->flash();

        return redirect()->back();
    }
}
