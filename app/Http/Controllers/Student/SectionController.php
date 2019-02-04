<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Hash;
use App\Teacher;
use App\Section;
use App\Track;
use App\Subject;
use App\Student;
use App\SectionStudent;
use App\SectionSubjectTeacher;
use App\SchoolYear;
use App\Grade;
use PDF;

class SectionController extends Controller
{
    public function classes() {
        // block other user to access student module
        if(Auth::guard('student')->check() != 1) {
            return redirect()->back();
        }

        $sectionStudents = SectionStudent::all();
        $studentSections = [];
        $sectionArr = [];
        $x = 0;

        foreach ($sectionStudents as $row) {
	        if ($row->student_id == Auth::guard('student')->user()->id) {
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
        	$sectionArr[$x++] = [
        		'id' => $section->id,
        		'name' => $section->name,
        		'schoolyear_id' => $schoolyear->id,
        		'schoolyear' => $schoolyear->year,
        		'track_id' => $track->id,
        		'track' => $track->name,
        		'year_level' => $section->year_level,
        		'semester' => $section->semester,
        		'adviser' => $teacher->firstname. ' ' .$teacher->lastname
        	];
        }

        $sectionArr =  json_decode(json_encode($sectionArr));
        // print_r($sectionArr);

        return view('students.section.classes')
        	->with('sections', $sectionArr);
    }

    public function class($id) {
    	// block other user to access student module
        if(Auth::guard('student')->check() != 1) {
            return redirect()->back();
        }

    	$section = Section::find($id);
    	$schoolyear = SchoolYear::find($section->schoolyear_id);
    	$track = Track::find($section->track_id);
    	$teacher = Teacher::find($section->adviser);
    	$selectedSection = [
    		'id' => $section->id,
    		'name' => $section->name,
    		'schoolyear_id' => $schoolyear->id,
    		'schoolyear' => $schoolyear->year,
    		'track_id' => $track->id,
    		'track' => $track->name,
    		'year_level' => $section->year_level,
    		'semester' => $section->semester,
    		'adviser' => $teacher->firstname. ' ' .$teacher->lastname
    	];

    	$sectionStudents = SectionStudent::all();
        $studentSections = [];
        $sectionArr = [];
        $x = 0;

    	foreach ($sectionStudents as $row) {
	        if ($row->student_id == Auth::guard('student')->user()->id) {
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
        	$sectionArr[$x++] = [
        		'id' => $section->id,
        		'name' => $section->name,
        		'schoolyear_id' => $schoolyear->id,
        		'schoolyear' => $schoolyear->year,
        		'track_id' => $track->id,
        		'track' => $track->name,
        		'year_level' => $section->year_level,
        		'semester' => $section->semester,
        		'adviser' => $teacher->firstname. ' ' .$teacher->lastname
        	];
        }

        $sectionArr =  json_decode(json_encode($sectionArr));


        // get grades
        $sectionSubject = SectionSubjectTeacher::all();
        $grades = Grade::all();
        foreach ($sectionSubject as $row) {
            if($row->teacher_id == null || $row->teacher_id == '') {
                
                Session::flash('error', 'The section doesnt have a teacher yet. Please contact the administrator');
                return redirect()->back();
            } else {
                if ($row->section_id == $selectedSection['id']) {
                    $subject = Subject::find($row->subject_id);
                    $teacher = Teacher::find($row->teacher_id);

                    $g = Grade::where([
                            ['teacher_id', '=', $teacher->id], 
                            ['subject_id', '=', $subject->id],
                            ['section_id', '=', $selectedSection['id']],
                            ['student_id', '=', Auth::guard('student')->user()->id]
                    ])->first();

                    $studentGrades[$x++] = [
                        'subject_id' => $subject->id,
                        'subject_code' => $subject->code,
                        'subject_description' => $subject->description,
                        'teacher_id' => $teacher->id,
                        'teacher_name' => $teacher->firstname. ' ' .$teacher->middlename. ' ' .$teacher->lastname,
                        'student_grade' => $g['grade'] ?? ' '
                    ];
                }
            }
        }

        $studentGrades = json_decode(json_encode($studentGrades));
        // print_r($studentGrades);

        return view('students.section.class')
        	->with('sections', $sectionArr)
        	->with('selectedSection', $selectedSection)
        	->with('studentGrades', $studentGrades);

    }

    public function information() {
        // block other user to access student module
        if(Auth::guard('student')->check() != 1) {
            return redirect()->back();
        }

        return view('students.information');
    }

    public function informationUpdate(Request $request) {
        // block other user to access student module
        if(Auth::guard('student')->check() != 1) {
            return redirect()->back();
        }

        $this->validate($request, [
            'contact' => 'max:191',
            'address1' => 'max:191',
            'address2' => 'max:191',
            'barangay' => 'max:191',
            'municipality' => 'max:191',
            'province' => 'max:191',
            'guardian' => 'max:191'
        ]);

        $student = Student::find(Auth::guard('student')->user()->id);
        $student->contact = $request->contact;
        $student->address1 = $request->address1;
        $student->address2 = $request->adrress2;
        $student->barangay = $request->barangay;
        $student->municipality = $request->municipality;
        $student->province = $request->province;
        $student->guardian = $request->guardian;
        $student->save();


        // show a success message
        Session::flash('success', 'success');

        return redirect()->route('student.information');
    }

    public function password() {
        // block other user to access student module
        if(Auth::guard('student')->check() != 1) {
            return redirect()->back();
        }

        return view('students.password');
    }

    public function passwordUpdate(Request $request) {
        // block other user to access student module
        if(Auth::guard('student')->check() != 1) {
            return redirect()->back();
        }

        if (Hash::check($request->oldpassword, Auth::guard('student')->user()->password)) {
            if ($request->newpassword != $request->newpasswordconfirmation) {
                Session::flash('error', 'New password and confirmation password does not match.');
                return redirect()->back();
            } else {
                $student = Student::find(Auth::guard('student')->user()->id);
                $student->password = bcrypt($request->newpassword);
                $student->save();

                // show a success message
                Session::flash('success', 'Password has been changed.');

                return redirect()->back();
            }
        } else {
            Session::flash('error', 'Old password does not match');
            return redirect()->back();
        }

    }


    // PDF

    public function gradesPdf($selectedSection)
    {
        // block other user to access student module
        if(Auth::guard('student')->check() != 1) {
            return redirect()->back();
        }
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->convert_student_grades_to_html($selectedSection));
		return $pdf->stream();
    }

    function convert_student_grades_to_html($selectedSectionId)
    {
        // block other user to access student module
        if(Auth::guard('student')->check() != 1) {
            return redirect()->back();
        }
    	// get grades
    	$section = Section::find($selectedSectionId);
    	$schoolyear = SchoolYear::find($section->schoolyear_id);
    	$track = Track::find($section->track_id);
    	$teacher = Teacher::find($section->adviser);
    	$sectionArr = [
    		'id' => $section->id,
    		'name' => $section->name,
    		'schoolyear_id' => $schoolyear->id,
    		'schoolyear' => $schoolyear->year,
    		'track_id' => $track->id,
    		'track' => $track->name,
    		'year_level' => $section->year_level,
    		'semester' => $section->semester,
    		'adviser' => $teacher->firstname. ' ' .$teacher->lastname
    	];
    	$x = 0;
        $sectionSubject = SectionSubjectTeacher::all();
        $grades = Grade::all();
        foreach ($sectionSubject as $row) {
            if($row->teacher_id == null || $row->teacher_id == '') {
                
                Session::flash('error', 'The section doesnt have a teacher yet. Please contact the administrator');
                return redirect()->back();
            } else {
                if ($row->section_id == $selectedSectionId) {
                    $subject = Subject::find($row->subject_id);
                    $teacher = Teacher::find($row->teacher_id);

                    $g = Grade::where([
                            ['teacher_id', '=', $teacher->id], 
                            ['subject_id', '=', $subject->id],
                            ['section_id', '=', $selectedSectionId],
                            ['student_id', '=', Auth::guard('student')->user()->id]
                    ])->first();

                    $studentGrades[$x++] = [
                        'subject_id' => $subject->id,
                        'subject_code' => $subject->code,
                        'subject_description' => $subject->description,
                        'teacher_id' => $teacher->id,
                        'teacher_name' => $teacher->firstname. ' ' .$teacher->middlename. ' ' .$teacher->lastname,
                        'student_grade' => $g['grade'] ?? ' '
                    ];
                }
            }
        }

        $studentGrades = json_decode(json_encode($studentGrades));
        
        $output = '<h3>'.$sectionArr['year_level'].' - '.$sectionArr['name'].'</h3>
        		   <h5>'.($sectionArr['semester'] == 1? '1ST SEMESTER':'2ND SEMESTER').'</h5>
        		   <h5><small>School Year: </small>'.$sectionArr['schoolyear'].'</h5>
        		   <h5><small>Adviser: </small>'.$sectionArr['adviser'].'</h5>
				     <table width="100%" style="border-collapse: collapse; border: 0px;">
				      <tr>
					    <th style="border: 1px solid; padding:12px;" width="20%">SUBJECT CODE</th>
					    <th style="border: 1px solid; padding:12px;" width="30%">DESCRIPTION</th>
					    <th style="border: 1px solid; padding:12px;" width="15%">GRADE</th>
					    <th style="border: 1px solid; padding:12px;" width="15%">TEACHER</th>
					   </tr>
				     ';  
		foreach($studentGrades as $row)
	    {
	      $output .= '
	      <tr>
	       <td style="border: 1px solid; padding:12px;">'.$row->subject_code.'</td>
	       <td style="border: 1px solid; padding:12px;">'.$row->subject_description.'</td>
	       <td style="border: 1px solid; padding:12px;">'.$row->student_grade.'</td>
	       <td style="border: 1px solid; padding:12px;">'.$row->teacher_name.'</td>
	      </tr>
	      ';
	    }
	    $output .= '</table>';
	    return $output;
    }

}
