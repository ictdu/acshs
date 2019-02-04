<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Section;
use App\Log;
use Auth;
use App\Track;
use App\SchoolYear;
use App\Teacher;
use App\Subject;
use App\Student;
use App\SectionSubjectTeacher;
use App\SectionStudent;

class SectionController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$sections = Section::orderBy('updated_at', 'desc')->get();
    	$sectionArr = [];
    	$x = 0;
        $cantDelete = [];
        $sections2 = SectionStudent::all();
        $sections3 = SectionSubjectTeacher::all();
        foreach ($sections2 as $row) {
            if (!in_array($row->section_id, $cantDelete)) {
                array_push($cantDelete, $row->section_id);
            }
        }

        foreach ($sections3 as $row) {
            if (!in_array($row->section_id, $cantDelete)) {
                array_push($cantDelete, $row->section_id);
            }
        }

    	foreach ($sections as $row) {
    		$schoolyear = SchoolYear::find($row->schoolyear_id);
    		$track = Track::find($row->track_id);
            $teacher = Teacher::find($row->adviser);
    		$sectionArr[$x++] = [
    			'id' => $row->id,
    			'name' => $row->name,
    			'schoolyear_id' => $row->schoolyear_id,
    			'schoolyear' => $schoolyear->year,
    			'track_id' => $row->track_id,
    			'track' => $track->name,
    			'year_level' => $row->year_level,
    			'semester' => $row->semester,
                'adviser' => $row->adviser,
                'adviser_name' => $teacher->firstname. ' ' .$teacher->lastname
    		];
    	}

    	$sectionArr = json_decode(json_encode($sectionArr));

    	return view('admin-grade-management.section.index')
            ->with('cantDelete', $cantDelete)
    		->with('sections', $sectionArr);
    }

    public function create() {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

        // $subjects = Subject::all();
    	$tracks = Track::all();
    	$schoolyears = SchoolYear::orderBy('year', 'desc')->get();
        $teachers = Teacher::all();

    	return view('admin-grade-management.section.create')
    		->with('tracks', $tracks)
    		->with('schoolyears', $schoolyears)
            ->with('teachers', $teachers);
    }

    public function store(Request $request) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'name' => 'required|max:191',
    		'schoolyear_id' => 'required|not_in:none',
    		'track_id' => 'required|not_in:none',
    		'year_level' => 'required|not_in:none',
    		'semester' => 'required|not_in:none',
            'adviser' => 'required|not_in:none'
    	]);

    	$section = New Section;
    	$section->name = $request->name;
    	$section->schoolyear_id = $request->schoolyear_id;
    	$section->track_id = $request->track_id;
    	$section->year_level = $request->year_level;
    	$section->semester = $request->semester;
        $section->adviser = $request->adviser;
    	$section->save();

    	// record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'class';
        $log->action = 'added a class';
        $log->crud = 'add';
        $log->save();

        // show a success message
        \Alert::success('The item has been added successfully.')->flash();

    	return redirect()->route('section.index');
    }

    public function edit($id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$section = Section::find($id);
        $teachers = Teacher::all();
    	$tracks = Track::all();
    	$schoolyears = SchoolYear::orderBy('year', 'desc')->get();

    	return view('admin-grade-management.section.edit')
    		->with('section', $section)
    		->with('tracks', $tracks)
    		->with('schoolyears', $schoolyears)
            ->with('teachers', $teachers);
    }

    public function update(Request $request, $id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'name' => 'required|max:191',
    		'schoolyear_id' => 'required|not_in:none',
    		'track_id' => 'required|not_in:none',
    		'year_level' => 'required|not_in:none',
    		'semester' => 'required|not_in:none',
            'adviser' => 'required|not_in:none'
    	]);

    	$section = Section::find($id);
    	$section->name = $request->name;
    	$section->schoolyear_id = $request->schoolyear_id;
    	$section->track_id = $request->track_id;
    	$section->year_level = $request->year_level;
    	$section->semester = $request->semester;
        $section->adviser = $request->adviser;
    	$section->save();

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'class';
        $log->action = 'modified a class';
        $log->crud = 'edit';
        $log->save();

        // show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

        return redirect()->route('section.index');
    }

    public function destroy($id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$section = Section::find($id);
    	$section->delete();

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'class';
        $log->action = 'deleted a class';
        $log->crud = 'delete';
        $log->save();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

    	return redirect()->back();
    }

    public function createSubjectTeacher($id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $ssts = SectionSubjectTeacher::where('section_id', $id)->get();
        $teachers = Teacher::all();
        $section = Section::find($id);
        $track = Track::find($section->track_id);
        $schoolyear = SchoolYear::find($section->schoolyear_id);
        $teacher = Teacher::find($section->adviser);
        $subjects = Subject::where('year_level', $section->year_level)->get();
        $sectionArr = [
            'id' => $section->id,
            'name' => $section->name,
            'schoolyear' => $schoolyear->year,
            'track' => $track->name,
            'year_level' => $section->year_level,
            'semester' => $section->semester,
            'adviser' => $teacher->firstname. ' ' .$teacher->lastname
        ];

        return view('admin-grade-management.section.subject-teacher')
            ->with('section', $sectionArr)
            ->with('subjects', $subjects)
            ->with('teachers', $teachers)
            ->with('ssts', $ssts);
    }

    public function storeSubjectTeacher(Request $request, $id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

        // print_r($_POST);
        if (in_array('none', $_POST)) {
            // show a error message
            \Alert::error('Invalid input')->flash();

            return redirect()->back();
        }
        /*$section_id = $id;
        $subject_id = $value;*/
        $subjectTeacherArr = array();
        $r = 0;
        $x = 1;
        $postLength = sizeof($_POST) - 1;
        foreach ($_POST as $key => $value) {
            if ($key == '_token') {
                continue;
            }
            if ($x % 2 != 0) {
                $section_id = $id;
                $subject_id = $value;
            } 
            if ($x % 2 == 0) {
                $subjectTeacherArr[$r] = [
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'teacher_id' => $value
                ];
                $r = $r + 1;
            }
            $x = $x + 1;

        }

        $subjectTeacherArr = json_decode(json_encode($subjectTeacherArr));

        foreach ($subjectTeacherArr as $row) {
            $sst = SectionSubjectTeacher::where([['section_id', $row->section_id], ['subject_id', $row->subject_id]])->first();
            if ($sst === null || $sst == '') {
                $sectionsubjecteacher = New SectionSubjectTeacher;
                $sectionsubjecteacher->section_id = $row->section_id;
                $sectionsubjecteacher->subject_id = $row->subject_id;
                $sectionsubjecteacher->teacher_id = $row->teacher_id;
                $sectionsubjecteacher->save();
            } else {
                $sst->section_id = $row->section_id;
                $sst->subject_id = $row->subject_id;
                $sst->teacher_id = $row->teacher_id;
                $sst->save();
            }
        }

        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'class_subject_teacher';
        $log->action = 'modified a class subjects and class teachers';
        $log->crud = 'edit';
        $log->save();

        // show a success message
        \Alert::success('The item has been added successfully.')->flash();

        return redirect()->back();
    }

    public function createStudent($id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $sts = SectionStudent::where('section_id', $id)->get();
        $stsArr = [];
        foreach ($sts as $row) {
            if (!in_array($row->student_id, $stsArr)) {
                array_push($stsArr, $row->student_id);
            }
        }

        $section = Section::find($id);
        $students = Student::where('track_id', $section->track_id)->get();
        $track = Track::find($section->track_id);
        $schoolyear = SchoolYear::find($section->schoolyear_id);
        $teacher = Teacher::find($section->adviser);
        $sectionArr = [
            'id' => $section->id,
            'name' => $section->name,
            'schoolyear' => $schoolyear->year,
            'track' => $track->name,
            'year_level' => $section->year_level,
            'semester' => $section->semester,
            'adviser' => $teacher->firstname. ' ' .$teacher->lastname
        ];

        return view('admin-grade-management.section.student')
            ->with('section', $sectionArr)
            ->with('sts', $stsArr)
            ->with('students', $students);

    }

    public function storeStudent(Request $request, $id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $this->validate($request, [
            'students' => 'required'
        ]);
        // print_r($_POST);
        // echo $_POST['students'][2];
        // echo sizeof($_POST);
        /*for ($i=0; $i < count($_POST); $i++) { 
            echo $_POST['students'][$i]."<br>";
        }*/

        $students = $request->input('students');
        $sts = SectionStudent::where('section_id', $id)->get();
        // delete first
        foreach ($sts as $row) {
            $st = SectionStudent::find($row->id);
            $st->delete();
        }

        foreach ($students as $key => $value) {
            $sectionStudent = New SectionStudent;
            $sectionStudent->section_id = $id;
            $sectionStudent->student_id = $value;
            $sectionStudent->save();
        }
        // $students = implode(',', $students);

        // $input = $request->except('students');
        //Assign the "mutated" students value to $input
        // $input['students'] = $students;

        // General_news::create($input);
        // print_r($students);

        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'class_student';
        $log->action = 'modified a class students';
        $log->crud = 'edit';
        $log->save();

        // show a success message
        \Alert::success('The item has been added successfully.')->flash();

        return redirect()->back();
    }

}
