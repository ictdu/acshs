<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GradeActivation;
use Auth;

class GradeController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$activation = GradeActivation::orderBy('created_at', 'desc')->first();
    	return view('admin-grade-management.settings')
    		->with('activation', $activation);
    }

    public function activation(Request $request) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $activation = GradeActivation::find($request->id);
        print_r($activation);
        if ($activation->status == 1) {
        	$activation->status = 0;
        	$activation->save();
        } else {
        	$activation->status = 1;
        	$activation->save();
        }

        // show a success message
        \Alert::success('Changes has been saved.')->flash();
        return redirect()->route('grade.settings.index');
        
    }
}
