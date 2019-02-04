<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School;
use Image;
use Auth;
use App\Log;

class SchoolnameController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
    	$schoolnames = School::orderBy('created_at', 'desc')->get();

    	return view('page-content.schoolname.index')
            ->with('schoolnames', $schoolnames);
    }

    public function create() {
    	return view('page-content.schoolname.create');
    }

    public function store(Request $request) {
    	$this->validate($request, [
    		'name' => 'required|max:191',
    		'abbreviation' => 'required|max:191'
    	]);

    	$schoolname = New School;
    	$schoolname->name = $request->name;
    	$schoolname->abbreviation = $request->abbreviation;
    	$schoolname->save();

        // record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'schoolname';
        $log->action = 'added a schoolname';
        $log->crud = 'add';
        $log->save();

    	// show a success message
        \Alert::success('The item has been added successfully.')->flash();

        return redirect()->route('schoolname.index');
    }

    public function edit($id) {
    	$schoolname = School::find($id);

    	return view('page-content.schoolname.edit')
    		->with('schoolname', $schoolname);
    }

    public function update(Request $request, $id) {
    	$this->validate($request, [
    		'name' => 'required|max:191',
    		'abbreviation' => 'required|max:191'
    	]);

    	$schoolname = School::find($id);

        // record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'schoolname';
        $log->action = 'modified a schoolname';
        $log->crud = 'edit';
        $log->save();


        // save
    	$schoolname->name = $request->name;
    	$schoolname->abbreviation = $request->abbreviation;
    	$schoolname->save();

    	// show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

        return redirect()->route('schoolname.index');
    }

    public function destroy($id) {
    	$schoolname = School::find($id);

        // record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'schoolname';
        $log->action = 'deleted a schoolname';
        $log->crud = 'delete';
        $log->save();

    	$schoolname->delete();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->route('schoolname.index');
    }
}
