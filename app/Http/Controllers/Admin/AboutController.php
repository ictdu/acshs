<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\About;
use Image;
use Auth;
use App\Log;

class AboutController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
    	$abouts = About::orderBy('created_at', 'desc')->get();

    	return view('page-content.about.index')
    		->with('abouts', $abouts);
    }

    public function create() {
    	return view('page-content.about.create');
    }

    public function store(Request $request) {
    	$this->validate($request, [
    		'mission' => 'required',
    		'vision' => 'required',
    		'objective' => 'required',
    		'email' => 'email|max:191',
    		'contact' => 'max:191'
    	]);

    	$about = New About;
    	$about->mission = $request->mission;
    	$about->vision = $request->vision;
    	$about->objectives = $request->objective;
    	$about->email = $request->email;
    	$about->contact = $request->contact;
    	$about->save();

        // record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'about';
        $log->action = 'added an about';
        $log->crud = 'add';
        $log->save();

    	// show a success message
        \Alert::success('The item has been added successfully.')->flash();

        return redirect()->route('about.index');
    }

    public function edit($id) {
    	$about = About::find($id);

    	return view('page-content.about.edit')
    		->with('about', $about);
    }

    public function update(Request $request, $id) {
    	$this->validate($request, [
    		'mission' => 'required',
    		'vision' => 'required',
    		'objective' => 'required',
    		'email' => 'email|max:191',
    		'contact' => 'max:191'
    	]);

    	$about = About::find($id);
    	$about->mission = $request->mission;
    	$about->vision = $request->vision;
    	$about->objectives = $request->objective;
    	$about->email = $request->email;
    	$about->contact = $request->contact;
    	$about->save();

        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'about';
        $log->action = 'modified an about';
        $log->crud = 'edit';
        $log->save();

    	// show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

        return redirect()->route('about.index');
    }

    public function destroy($id) {
    	$about = About::find($id);
    	$about->delete();

        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'about';
        $log->action = 'deleted an about';
        $log->crud = 'delete';
        $log->save();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->route('about.index');
    }
}
