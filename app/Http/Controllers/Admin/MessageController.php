<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
use Carbon\Carbon;
use Auth;
use App\Log;

class MessageController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index()
    {
        $messages = Message::orderBy('created_at', 'desc')->get();

        return view('inbox.index')
            ->with('messages', $messages);
    }

    public function destroy($id) {

    	$message = Message::find($id);

        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'inbox';
        $log->action = 'deleted a message';
        $log->crud = 'delete';
        $log->save();

        // delete msg
    	$message->delete();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

    	return redirect()->route('message.index');
    }

    public function show(Request $request) {
        if($request->ajax()) {
            $message = Message::find($request->id);
            
            // $dat = date('Y-m-d H:i:s', strtotime($message->created_at));
            return response()->json($message);
            // echo $messageArr;
        }
    }

    public function destroyAll() {
        Message::truncate();

        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'inbox';
        $log->action = 'deleted all messages';
        $log->crud = 'delete';
        $log->save();

        // show a success message
        \Alert::success('Items has been deleted.')->flash();

        return redirect()->back();
    }
}
