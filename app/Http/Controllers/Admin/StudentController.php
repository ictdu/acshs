<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use Auth;
use App\Log;
use App\Teacher;
use App\Section;
use App\Track;
use App\SchoolYear;
use Response;
use App\SectionStudent;
use App\SectionSubjectTeacher;
use App\Grade;
use App\Subject;

class StudentController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$students = Student::orderBy('updated_at', 'desc')->get();
    	$studentArr = [];
    	$x = 0;
        $cantDelete = [];
        $sections = SectionStudent::all();
        foreach ($sections as $row) {
            if (!in_array($row->student_id, $cantDelete)) {
                array_push($cantDelete, $row->student_id);
            }
        }

    	foreach ($students as $row) {
    		$track = Track::find($row->track_id);
    		$studentArr[$x++] = [
    			'id' => $row->id,
    			'lrn' => $row->lrn,
    			'firstname' => $row->firstname,
    			'lastname' => $row->lastname,
    			'track' => $track->name
    		];
    	}

    	$studentArr = json_decode(json_encode($studentArr));

    	return view('admin-grade-management.student.index')
            ->with('cantDelete', $cantDelete)
    		->with('students', $studentArr);
    }

    public function create() {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$tracks = Track::all();

    	return view('admin-grade-management.student.create')
    		->with('tracks', $tracks);
    }

    public function store(Request $request) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'track_id' => 'required|not_in:none',
    		'lrn' => 'required|max:191|unique:student,lrn',
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
    		'province' => 'sometimes|max:191',
    		'guardian' => 'sometimes|max:191'
    	]);

    	$student = New Student;
    	$student->lrn = $request->lrn;
    	$student->track_id = $request->track_id;
    	$student->firstname = $request->firstname;
    	$student->middlename = $request->middlename;
    	$student->lastname = $request->lastname;
    	$student->gender = $request->gender;
    	$student->birthday = $request->birthday;
    	$student->contact = $request->contact;
    	$student->religion = $request->religion;
    	$student->address1 = $request->address1;
    	$student->address2 = $request->address2;
    	$student->barangay = $request->barangay;
    	$student->municipality = $request->municipality;
    	$student->province = $request->province;
    	$student->guardian = $request->guardian;
    	$student->password = bcrypt('987654321');
    	$student->save();

    	// record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'student';
        $log->action = 'added a student';
        $log->crud = 'add';
        $log->save();

        // show a success message
        \Alert::success('The item has been added successfully.')->flash();

    	return redirect()->route('student.index');
    }

    public function edit($id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$tracks = Track::all();
    	$student = Student::find($id);

    	return view('admin-grade-management.student.edit')
    		->with('tracks', $tracks)
    		->with('student', $student);
    }

    public function update(Request $request, $id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$student = Student::find($id);
    	if ($request->lrn == $student->lrn) {
    		$this->validate($request, [
	    		'track_id' => 'required|not_in:none',
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
	    		'province' => 'sometimes|max:191',
	    		'guardian' => 'sometimes|max:191'
	    	]);
    	} else {
	    	$this->validate($request, [
	    		'track_id' => 'required|not_in:none',
	    		'lrn' => 'required|max:191|unique:student,lrn',
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
	    		'province' => 'sometimes|max:191',
	    		'guardian' => 'sometimes|max:191'
	    	]);
    	}

    	$student->lrn = $request->lrn;
    	$student->track_id = $request->track_id;
    	$student->firstname = $request->firstname;
    	$student->middlename = $request->middlename;
    	$student->lastname = $request->lastname;
    	$student->gender = $request->gender;
    	$student->birthday = $request->birthday;
    	$student->contact = $request->contact;
    	$student->religion = $request->religion;
    	$student->address1 = $request->address1;
    	$student->address2 = $request->address2;
    	$student->barangay = $request->barangay;
    	$student->municipality = $request->municipality;
    	$student->province = $request->province;
    	$student->guardian = $request->guardian;
    	$student->save();

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'student';
        $log->action = 'modified a student';
        $log->crud = 'edit';
        $log->save();

        // show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

        return redirect()->route('student.index');
    }

    public function destroy($id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$student = Student::find($id);
    	$student->delete();

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'student';
        $log->action = 'deleted a student';
        $log->crud = 'delete';
        $log->save();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

    	return redirect()->back();
    }

    public function resetPassword($id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$student = Student::find($id);
    	$student->password = bcrypt('987654321');

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'student';
        $log->action = 'reset a student password';
        $log->crud = 'reset';
        $log->save();

    	// show a success message
        \Alert::success('Password has been reset.')->flash();

    	return redirect()->back();
    }

    public function vImport() {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	return view('admin-grade-management.student.import');
    }

    public function downloadTemplate(){
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $file = public_path()."/Student Template.csv";
        $headers = array('Content-Type: application/csv',);
        // header('Content-type: text/csv');
        return Response::download($file, 'StudentTemplate.csv',$headers);
    }

    public function cImport(Request $request) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $studentArr = [];
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
                $checkstudent = Student::where('lrn', $data[0])->first();
                if ($checkstudent == null || $checkstudent == '') { // means this row doesnt exist in the table
                    $student = New Student;
                    $student->lrn = $data[0];
                    $student->track_id = $data[1];
                    $student->firstname = $data[2];
                    $student->middlename = $data[3];
                    $student->lastname = $data[4];
                    $student->gender = $data[5];
                    // converting date
                    $date = str_replace('/', '-', $data[6]);
                    $student->birthday = date("Y-m-d", strtotime($date));
                    $student->password = bcrypt('987654321');
                    $student->save();

                    // record activity
                    $log = New Log;
                    $log->user_id = Auth::user()->id;
                    $log->type = 'student';
                    $log->action = 'added a student using excel file';
                    $log->crud = 'add';
                    $log->save();

                } else {
                    $duplicateCtr++;
                }
            }
            fclose($handle);
            
            \Alert::success('File has been processed')->flash();
            return redirect()->route('student.index');
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

        $student  = Student::find($id);

        $sectionStudents = SectionStudent::all();
        $studentSections = [];
        $sectionArr = [];
        $x = 0;
        $r = 0;

        foreach ($sectionStudents as $row) {
            if ($row->student_id == $id) {
                if (!in_array($row->section_id, $studentSections)) {
                    array_push($studentSections, $row->section_id);
                }
            }
        }

        foreach ($studentSections as $key => $value) {
            $section = Section::find($value);
            $schoolyear = SchoolYear::find($section->schoolyear_id);
            $track = Track::find($section->track_id);
            $teacher = Teacher::find($section->adviser);

            // get grades
            $sectionSubject = SectionSubjectTeacher::all();
            $grades = Grade::all();
            foreach ($sectionSubject as $row) {
                if ($row->section_id == $section->id) {

                    $subject = Subject::find($row->subject_id);
                    $teacher = Teacher::find($row->teacher_id);

                    $g = Grade::where([
                            ['teacher_id', '=', $teacher->id], 
                            ['subject_id', '=', $subject->id],
                            ['section_id', '=', $section->id],
                            ['student_id', '=', $id]
                    ])->first();

                    $studentGrades[$r++] = [
                        'subject_id' => $subject->id,
                        'subject_code' => $subject->code,
                        'subject_description' => $subject->description,
                        'teacher_id' => $teacher->id,
                        'teacher_name' => $teacher->firstname. ' ' .$teacher->middlename. ' ' .$teacher->lastname,
                        'student_grade' => $g['grade'] ?? ' '
                    ];

                }
            }

            $sectionArr[$x++] = [
                'id' => $section->id,
                'name' => $section->name,
                'schoolyear_id' => $schoolyear->id,
                'schoolyear' => $schoolyear->year,
                'track_id' => $track->id,
                'track' => $track->name,
                'year_level' => $section->year_level,
                'semester' => $section->semester,
                'adviser' => $teacher->firstname. ' ' .$teacher->lastname,
                'grades' => $studentGrades
            ];
        }

        // $studentGrades = json_decode(json_encode($studentGrades));

        $sectionArr =  json_decode(json_encode($sectionArr));

        // print_r($sectionArr);

        /*foreach ($sectionArr as $row) {
            echo $row->name;
            foreach ($row->grades as $grade) {
                echo $grade->subject_code.' | '. $grade->student_grade. "<br>";
            }

        }*/

        return view('admin-grade-management.student.show')
            ->with('student', $student)
            ->with('sections', $sectionArr);
    }

}
