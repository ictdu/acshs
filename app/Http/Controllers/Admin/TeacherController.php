<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Teacher;
use Auth;
use App\Log;
use Response;
use App\SectionSubjectTeacher;
use App\Section;
use App\Track;
use App\SchoolYear;

class TeacherController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$teachers = Teacher::orderBy('updated_at', 'desc')->get();
        $cantDelete = [];
        $sections = SectionSubjectTeacher::all();
        $sections2 = Section::all();
        foreach ($sections as $row) {
            if (!in_array($row->teacher_id, $cantDelete)) {
                array_push($cantDelete, $row->teacher_id);
            }
        }

        foreach ($sections2 as $row) {
            if (!in_array($row->adviser, $cantDelete)) {
                array_push($cantDelete, $row->adviser);
            }
        }

    	return view('admin-grade-management.teacher.index')
            ->with('cantDelete', $cantDelete)
    		->with('teachers', $teachers);
    }

    public function create() {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	return view('admin-grade-management.teacher.create');
    }

    public function store(Request $request) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'employee_id' => 'required|max:191|unique:teacher,employee_id',
    		'firstname' => 'required|max:191',
    		'middlename' => 'sometimes|max:191',
    		'lastname' => 'required|max:191',
    		'gender' => 'required|not_in:none',
    		'birthday' => 'required',
    		'contact' => 'sometimes|max:191',
    		'religion' => 'sometimes|max:191',
    		'address1' => 'sometimes|max:191',
    		'address2' => 'sometimes|max:191',
    		'barangay' => 'sometimes|max:191',
    		'municipality' => 'sometimes|max:191',
    		'province' => 'sometimes|max:191'
    	]);

    	$teacher = New Teacher;
    	$teacher->employee_id = $request->employee_id;
    	$teacher->firstname = $request->firstname;
    	$teacher->middlename = $request->middlename;
    	$teacher->lastname = $request->lastname;
    	$teacher->gender = $request->gender;
    	$teacher->birthday = $request->birthday;
    	$teacher->contact = $request->contact;
    	$teacher->address1 = $request->address1;
    	$teacher->address2 = $request->address2;
    	$teacher->barangay = $request->barangay;
    	$teacher->municipality = $request->municipality;
    	$teacher->province = $request->province;
    	$teacher->password = bcrypt('123456789');
    	$teacher->save();

    	// record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'teacher';
        $log->action = 'added a teacher';
        $log->crud = 'add';
        $log->save();

        // show a success message
        \Alert::success('The item has been added successfully.')->flash();

    	return redirect()->route('teacher.index');
    }

    public function edit($id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$teacher = Teacher::find($id);

    	return view('admin-grade-management.teacher.edit')
    		->with('teacher', $teacher);
    }

    public function update(Request $request, $id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $teacher = Teacher::find($id);
        if ($teacher->employee_id == $request->employee_id) {
        	$this->validate($request, [
	        	'employee_id' => 'required|max:191',
	    		'firstname' => 'required|max:191',
	    		'middlename' => 'sometimes|max:191',
	    		'lastname' => 'required|max:191',
	    		'gender' => 'required|not_in:none',
	    		'birthday' => 'required',
	    		'contact' => 'sometimes|max:191',
	    		'religion' => 'sometimes|max:191',
	    		'address1' => 'sometimes|max:191',
	    		'address2' => 'sometimes|max:191',
	    		'barangay' => 'sometimes|max:191',
	    		'municipality' => 'sometimes|max:191',
	    		'province' => 'sometimes|max:191'
	        ]);
        } else {

	        $this->validate($request, [
	        	'employee_id' => 'required|max:191|unique:teacher,employee_id',
	    		'firstname' => 'required|max:191',
	    		'middlename' => 'sometimes|max:191',
	    		'lastname' => 'required|max:191',
	    		'gender' => 'required|not_in:none',
	    		'birthday' => 'required',
	    		'contact' => 'sometimes|max:191',
	    		'religion' => 'sometimes|max:191',
	    		'address1' => 'sometimes|max:191',
	    		'address2' => 'sometimes|max:191',
	    		'barangay' => 'sometimes|max:191',
	    		'municipality' => 'sometimes|max:191',
	    		'province' => 'sometimes|max:191'
	        ]);
	    }

        $teacher = Teacher::find($id);
    	$teacher->employee_id = $request->employee_id;
    	$teacher->firstname = $request->firstname;
    	$teacher->middlename = $request->middlename;
    	$teacher->lastname = $request->lastname;
    	$teacher->gender = $request->gender;
    	$teacher->birthday = $request->birthday;
    	$teacher->contact = $request->contact;
    	$teacher->address1 = $request->address1;
    	$teacher->address2 = $request->address2;
    	$teacher->barangay = $request->barangay;
    	$teacher->municipality = $request->municipality;
    	$teacher->province = $request->province;
    	$teacher->save();

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'teacher';
        $log->action = 'modified a teacher';
        $log->crud = 'edit';
        $log->save();

        // show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

        return redirect()->route('teacher.index');
    }

    public function destroy($id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$teacher = Teacher::find($id);
    	$teacher->delete();

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'teacher';
        $log->action = 'deleted a teacher';
        $log->crud = 'delete';
        $log->save();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

    	return redirect()->back();
    }

    public function resetPassword($id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$teacher = Teacher::find($id);
    	$teacher->password = bcrypt('123456789');

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'teacher';
        $log->action = 'reset a teacher password';
        $log->crud = 'reset';
        $log->save();

    	// show a success message
        \Alert::success('Password has been reset.')->flash();

    	return redirect()->back();
    }

    public function vImport() {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	return view('admin-grade-management.teacher.import');
    }

    public function downloadTemplate(){
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $file = public_path()."/Teacher Template.csv";
        $headers = array('Content-Type: application/csv',);
        // header('Content-type: text/csv');
        return Response::download($file, 'TeacherTemplate.csv',$headers);
    }

    public function cImport(Request $request) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $teacherArr = [];
        $x = 0;
        $duplicateCtr = 0;

        $fname = $_FILES['sel_file']['name'];
        $chk_ext = explode(".", $fname);
        $skipFirstRow = true;

        if (strtolower(end($chk_ext)) == "csv") {
        	$filename = $_FILES['sel_file']['tmp_name'];
        	$handle = fopen($filename, "r");

        	fgetcsv($handle);
        	while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
        		$checkTeacher = Teacher::where('employee_id', $data[0])->first();
        		if ($checkTeacher == null || $checkTeacher == '') { // means this row doesnt exist in the table
        			$teacher = New Teacher;
        			$teacher->employee_id = $data[0];
        			$teacher->firstname = $data[1];
        			$teacher->middlename = $data[2];
        			$teacher->lastname = $data[3];
        			$teacher->gender = $data[4];
        			// converting date
        			$date = str_replace('/', '-', $data[5]);
        			$teacher->birthday = date("Y-m-d", strtotime($date));
        			$teacher->password = bcrypt('123456789');
        			$teacher->save();

        			// record activity
			        $log = New Log;
			        $log->user_id = Auth::user()->id;
			        $log->type = 'teacher';
			        $log->action = 'added a teacher using excel file';
			        $log->crud = 'add';
			        $log->save();

        		} else {
        			$duplicateCtr++;
        		}
        	}
        	fclose($handle);
        	
        	\Alert::success('File has been processed')->flash();
            return redirect()->route('teacher.index');
        } 
        // invalid file ext
        else {
        	// show a error message
        	\Alert::error('Invalid File.')->flash();
            return redirect()->back();
        }
    }

    public function show($id) {

        // block other user
        abort_if(Auth::user()->user_type == 2, 404);
        
        $teacher  = Teacher::find($id);
        $sections = Section::where('adviser', $id)->get();
        $sectionArr = [];
        $x = 0;

        foreach ($sections as $row) {
            $schoolyear = SchoolYear::find($row->schoolyear_id);
            $track = Track::find($row->track_id);
            $sectionArr[$x++] = [
                'id' => $row->id,
                'name' => $row->name,
                'schoolyear_id' => $row->schoolyear_id,
                'schoolyear' => $schoolyear->year,
                'track_id' => $row->track_id,
                'track' => $track->name,
                'year_level' => $row->year_level,
                'semester' => $row->semester
            ];
        }

        $sectionArr = json_decode(json_encode($sectionArr));

        return view('admin-grade-management.teacher.show')
            ->with('teacher', $teacher)
            ->with('sections', $sectionArr);
    }

}
