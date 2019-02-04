<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SchoolYear;
use App\Log;
use App\Section;
use App\Track;
use App\Teacher;
use Auth;

class SchoolYearController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$schoolyears = SchoolYear::orderBy('updated_at', 'desc')->get();
        $sections = Section::all();
        $schoolyearCantBeDelete = [];
        foreach ($sections as $row) {
            if (!in_array($row->schoolyear_id, $schoolyearCantBeDelete)) {
                array_push($schoolyearCantBeDelete, $row->schoolyear_id);
            }
        }

    	return view('admin-grade-management.schoolyear.index')
    		->with('schoolyears', $schoolyears)
            ->with('schoolyearCantBeDelete', $schoolyearCantBeDelete);
    }

    public function create() {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	// value for school year
    	$yearsArr = [];
        for ($year=date("Y")+1; $year >= 1900 ; $year--) { 
        	$start = $year - 1;
            $yearsArr[$year] = $start .' - '. $year;
        }

    	return view('admin-grade-management.schoolyear.create')
    		->with('years', $yearsArr);
    }

    public function store(Request $request) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'year' => 'required|not_in:none|unique:schoolyear,year'
    	]);

    	$schoolyear = New SchoolYear;
    	$schoolyear->year = $request->year;
    	$schoolyear->save();

    	// record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'schoolyear';
        $log->action = 'added a schoolyear';
        $log->crud = 'add';
        $log->save();

    	// show a success message
        \Alert::success('The item has been added successfully.')->flash();

    	return redirect()->route('schoolyear.index');
    }

    public function edit($id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$schoolyear = SchoolYear::find($id);

    	// value for school year
    	$yearsArr = [];
        for ($year=date("Y")+1; $year >= 1900 ; $year--) { 
        	$start = $year - 1;
            $yearsArr[$year] = $start .' - '. $year;
        }

    	return view('admin-grade-management.schoolyear.edit')
    		->with('schoolyear', $schoolyear)
    		->with('years', $yearsArr);
    }

    public function update(Request $request, $id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $schoolyear = SchoolYear::find($id);
        if ($schoolyear->year == $request->year) {
            $this->validate($request, [
                'year' => 'required|not_in:none'
            ]);
        } else {
            $this->validate($request, [
                'year' => 'required|not_in:none|unique:schoolyear,year'
            ]);
        }

    	$schoolyear = SchoolYear::find($id);
    	$schoolyear->year = $request->year;
    	$schoolyear->save();

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'schoolyear';
        $log->action = 'modified a schoolyear';
        $log->crud = 'edit';
        $log->save();

    	// show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

    	return redirect()->route('schoolyear.index');
    }

    public function destroy($id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);
        
    	$schoolyear = SchoolYear::find($id);
    	$schoolyear->delete();

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'schoolyear';
        $log->action = 'deleted a schoolyear';
        $log->crud = 'delete';
        $log->save();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

    	return redirect()->back();
    }

    public function show($id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $schoolyear = SchoolYear::find($id);
        $sections = Section::where('schoolyear_id', $schoolyear->id)->get();
        $sectionArr = [];
        $x = 0;
        foreach ($sections as $row) {
            $track = Track::find($row->track_id);
            $teacher = Teacher::find($row->adviser);
            $sectionArr[$x++] = [
                'id' => $row->id,
                'name' => $row->name,
                'track_id' => $row->track_id,
                'track' => $track->name,
                'year_level' => $row->year_level,
                'semester' => $row->semester,
                'adviser' => $teacher->firstname. ' ' .$teacher->lastname
            ];
        }
        $sectionArr = json_decode(json_encode($sectionArr));

        // print_r($sectionArr);

        return view('admin-grade-management.schoolyear.show')
            ->with('schoolyear', $schoolyear)
            ->with('sections', $sectionArr);

    }
}
