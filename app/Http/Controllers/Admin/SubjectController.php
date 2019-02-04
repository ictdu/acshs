<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subject;
use Auth;
use App\Log;
use App\SectionSubjectTeacher;

class SubjectController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$subjects = Subject::orderBy('updated_at', 'desc')->get();
        $cantDelete = [];
        $sections = SectionSubjectTeacher::all();
        foreach ($sections as $row) {
            if (!in_array($row->subject_id, $cantDelete)) {
                array_push($cantDelete, $row->subject_id);
            }
        }

    	return view('admin-grade-management.subject.index')
            ->with('cantDelete', $cantDelete)
    		->with('subjects', $subjects);
    }

    public function create() {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	return view('admin-grade-management.subject.create');
    }

    public function store(Request $request) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'code' => 'required|max:191',
    		'description' => 'required',
    		'year_level' => 'required|not_in:none'
    	]);

    	$subject = New Subject;
    	$subject->code = $request->code;
    	$subject->description = $request->description;
    	$subject->year_level = $request->year_level;
    	$subject->save();

    	// record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'subject';
        $log->action = 'added a subject';
        $log->crud = 'add';
        $log->save();

    	// show a success message
        \Alert::success('The item has been added successfully.')->flash();

    	return redirect()->route('subject.index');
    }

    public function edit($id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$subject = Subject::find($id);

    	return view('admin-grade-management.subject.edit')
    		->with('subject', $subject);
    }

    public function update(Request $request, $id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'code' => 'required|max:191',
    		'description' => 'required',
    		'year_level' => 'required|not_in:none'
    	]);

    	$subject = Subject::find($id);
    	$subject->code = $request->code;
    	$subject->description = $request->description;
    	$subject->year_level = $request->year_level;
    	$subject->save();

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'subject';
        $log->action = 'modified a subject';
        $log->crud = 'edit';
        $log->save();

    	// show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

    	return redirect()->route('subject.index');
    }

    public function destroy($id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);
        
    	$subject = Subject::find($id);
    	$subject->delete();

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'subject';
        $log->action = 'deleted a subject';
        $log->crud = 'delete';
        $log->save();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

    	return redirect()->back();
    }
}
