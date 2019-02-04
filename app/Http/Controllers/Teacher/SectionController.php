<?php

namespace App\Http\Controllers\Teacher;

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
use App\GradeActivation;

class SectionController extends Controller
{

    public function dashboard() {
        // block other user to access teacher module
        if(Auth::guard('teacher')->check() != 1) {
            return redirect()->back();
        }

        $sections = Section::where('adviser', Auth::guard('teacher')->user()->id)->get();
        $sectionArr = [];
        $x = 0;

        foreach ($sections as $row) {
            $track = Track::find($row->track_id);
            $schoolyear = SchoolYear::find($row->schoolyear_id);
            $students = SectionStudent::where('section_id', $row->id)->get();
            $sectionArr[$x++] = [
                'id' => $row->id,
                'name' => $row->name,
                'schoolyear_id' => $row->schoolyear_id,
                'schoolyear' => $schoolyear->year,
                'track_id' => $row->track_id,
                'track' => $track->name,
                'year_level' => $row->year_level,
                'semester' => $row->semester,
                'students' => $students->count()
            ];
        }

        $sectionArr = json_decode(json_encode($sectionArr));

        // print_r($sectionArr);
        // echo Auth::guard('teacher')->user();

        return view('teacher.section.index')
            ->with('sections', $sectionArr);
    }

    public function sectionSubjects($id) {
        // block other user to access teacher module
        if(Auth::guard('teacher')->check() != 1) {
            return redirect()->back();
        }

        $section = Section::find($id);
        $ssts = SectionSubjectTeacher::where('section_id', $id)->get();
        $sts = SectionStudent::where('section_id', $id)->get();
        $sectionSubjects = [];
        $sectionStudents = [];
        $x = 0;
        $s = 0;
        foreach ($ssts as $row) {
            $subject = Subject::find($row->subject_id);
            $teacher = Teacher::find($row->teacher_id);
            $sectionSubjects[$x++] = [
                'id' => $row->id,
                'subject_id' => $row->subject_id,
                'subject_code' => $subject->code,
                'subject_description' => $subject->description,
                'teacher_id' => $row->teacher_id,
                'teacher_name' => $teacher->firstname. ' ' .$teacher->lastname
            ];
        }

        foreach ($sts as $row) {
            $student = Student::find($row->student_id);
            $sectionStudents[$s++] = [
                'id' => $row->student_id,
                'lrn' => $student->lrn,
                'name' => $student->lastname.', '.$student->firstname.' '.$student->middlename,
                'gender' => $student->gender
            ];
        }

        $track = Track::find($section->track_id);
        $schoolyear = SchoolYear::find($section->schoolyear_id);
        $sectionArr = [
            'id' => $section->id,
            'name' => $section->name,
            'schoolyear' => $schoolyear->year,
            'track' => $track->name,
            'year_level' => $section->year_level,
            'semester' => $section->semester
        ];

        $sectionSubjects = json_decode(json_encode($sectionSubjects));
        $sectionStudents = json_decode(json_encode($sectionStudents));

        return view('teacher.section.subjects')
            ->with('sectionSubjects', $sectionSubjects)
            ->with('sectionStudents', $sectionStudents)
            ->with('section', $sectionArr);
    }

    public function sectionStudent($section_id, $student_id) {
        $x = 0;
        $section = Section::find($section_id);
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
                            ['student_id', '=', $student_id]
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
        $student = Student::find($student_id);

        // print_r($studentGrades);
        return view('teacher.section.student')
            ->with('student', $student)
            ->with('studentGrades', $studentGrades)
            ->with('selectedSection', $selectedSection);
    }

    public function sectionSubject($section_id, $subject_id) {

        // block other user to access teacher module
        if(Auth::guard('teacher')->check() != 1) {
            return redirect()->back();
        }

        $gradeBlock = true;
        $gradeActivation = GradeActivation::orderBy('created_at', 'desc')->first();
        if ($gradeActivation->status == 1) {
            $gradeBlock = false;
        }

        $section = Section::find($section_id);
        $ssts = SectionSubjectTeacher::where('section_id', $section_id)->get();
        $sts = SectionStudent::where('section_id', $section_id)->get();
        $sectionSubjects = [];
        $sectionStudents = [];
        $x = 0;
        $s = 0;
        $selectedSubject = Subject::find($subject_id);
        $selectedTeacherID = 0;

        foreach ($ssts as $row) {
            $subject = Subject::find($row->subject_id);
            $teacher = Teacher::find($row->teacher_id);
            $sectionSubjects[$x++] = [
                'id' => $row->id,
                'subject_id' => $row->subject_id,
                'subject_code' => $subject->code,
                'subject_description' => $subject->description,
                'teacher_id' => $row->teacher_id,
                'teacher_name' => $teacher->firstname. ' ' .$teacher->lastname
            ];
        }

        foreach ($sts as $row) {
            $student = Student::find($row->student_id);
            $sectionStudents[$s++] = [
                'id' => $row->student_id,
                'lrn' => $student->lrn,
                'name' => $student->lastname.', '.$student->firstname.' '.$student->middlename,
                'gender' => $student->gender
            ];
        }

        $track = Track::find($section->track_id);
        $schoolyear = SchoolYear::find($section->schoolyear_id);
        $sectionArr = [
            'id' => $section->id,
            'name' => $section->name,
            'schoolyear' => $schoolyear->year,
            'track' => $track->name,
            'year_level' => $section->year_level,
            'semester' => $section->semester
        ];

        $sectionSubjects = json_decode(json_encode($sectionSubjects));
        $sectionStudents = json_decode(json_encode($sectionStudents));

        // getting the teacher of the selected subject
        foreach ($sectionSubjects as $row) {
            if ($selectedSubject->id == $row->subject_id) {
                $selectedTeacherID = $row->teacher_id;
                break;
            }
        }

        $grades = $gradeE = Grade::where([['section_id', $section_id], ['subject_id', $subject_id], ['teacher_id', $selectedTeacherID]])->get();
        $gradeArr = [];
        $g = 0;
        foreach ($grades as $row) {
            $remark = '';
            
            if ($row->grade != null) {
                if ($row->grade >= 75) {
                    $remark = 'PASSED';
                } else {
                    $remark = 'FAILED';
                }
            }
            $gradeArr[$g++] = [
                'id' => $row->id,
                'section_id' => $row->section_id,
                'subject_id' => $row->subject_id,
                'teacher_id' => $row->teacher_id,
                'student_id' => $row->student_id,
                'grade' => $row->grade,
                'remark' => $remark
            ];
        }

        $gradeArr = json_decode(json_encode($gradeArr));

        return view('teacher.section.subject')
            ->with('sectionSubjects', $sectionSubjects)
            ->with('selectedSubject', $selectedSubject)
            ->with('selectedTeacherID', $selectedTeacherID)
            ->with('sectionStudents', $sectionStudents)
            ->with('section', $sectionArr)
            ->with('grades', $gradeArr)
            ->with('gradeBlock', $gradeBlock);
    }

    public function sectionSubjectExcel($section_id, $subject_id, $teacher_id) {

        // block other user to access teacher module
        if(Auth::guard('teacher')->check() != 1) {
            return redirect()->back();
        }

        $section = Section::find($section_id);
        $ssts = SectionSubjectTeacher::where('section_id', $section_id)->get();
        $sts = SectionStudent::where('section_id', $section_id)->get();
        $sectionSubjects = [];
        $sectionStudents = [];
        $x = 0;
        $s = 0;
        $selectedSubject = Subject::find($subject_id);
   
        // section students
        foreach ($sts as $row) {
            $student = Student::find($row->student_id);
            $sectionStudents[$s++] = [
                'id' => $row->student_id,
                'lrn' => $student->lrn,
                'name' => $student->lastname.', '.$student->firstname.' '.$student->middlename,
                'gender' => $student->gender
            ];
        }

        // section
        $track = Track::find($section->track_id);
        $schoolyear = SchoolYear::find($section->schoolyear_id);
        $sectionArr = [
            'id' => $section->id,
            'name' => $section->name,
            'schoolyear' => $schoolyear->year,
            'track' => $track->name,
            'year_level' => $section->year_level,
            'semester' => $section->semester
        ];

        $sectionStudents = json_decode(json_encode($sectionStudents));

        echo $teacher_id;

        $grades = $gradeE = Grade::where([['section_id', $section_id], ['subject_id', $subject_id], ['teacher_id', $teacher_id]])->get();
        $gradeArr = [];
        $g = 0;
        foreach ($grades as $row) {
            $remark = '';
            
            if ($row->grade != null) {
                if ($row->grade >= 75) {
                    $remark = 'PASSED';
                } else {
                    $remark = 'FAILED';
                }
            }
            $gradeArr[$g++] = [
                'id' => $row->id,
                'section_id' => $row->section_id,
                'subject_id' => $row->subject_id,
                'teacher_id' => $row->teacher_id,
                'student_id' => $row->student_id,
                'grade' => $row->grade,
                'remark' => $remark
            ];
        }

        $gradeArr = json_decode(json_encode($gradeArr));

        // export
        $dataToDownload = [];
        $d = 0;
        $semester = $sectionArr['semester'] == 1? 'FIRST SEMESTER FINAL GRADES':'SECOND SEMESTER FINALS GRADES';

        $csvName = $sectionArr['year_level']. '-' .$sectionArr['name'].'.Students'. '.' .$selectedSubject->description;

        // output headers so that the file is downloaded rather than displayed
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename='.$csvName.'.csv');
         
        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');
         
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');
         
        // send the column headers
        fputcsv($file, array('NAME', 'GENDER', $semester, 'REMARKS'));
        foreach ($sectionStudents as $row) {
            $sGrade ='';
            $sRemark = '';

            foreach ($gradeArr as $grade) {
                if ($grade->student_id == $row->id) {
                    $sGrade = $grade->grade;
                    $sRemark = $grade->remark;
                }
            }
            $dataToDownload[$d++] = [
                'name' => $row->name,
                'gender' => $row->gender,
                'grade' => $sGrade,
                'remark' => $sRemark
            ];
        }
    
         
        //print_r($dataToDownload);
        // output each row of the data
        foreach ($dataToDownload as $row)
        {
        fputcsv($file, $row);
        }
         
        exit();
    }

    public function saveGrades($section_id, $subject_id, $teacher_id) {
        // block other user to access teacher module
        if(Auth::guard('teacher')->check() != 1) {
            return redirect()->back();
        }

        print_r($_POST);
        $gradeArr = [];
        $x = 0;
        $counter = 1;
        foreach ($_POST as $key => $value) {
            if ($key == '_token') {
                continue;
            }

            /*if($counter == 1) {
                $student_id = substr($key, strpos($key, '_') + 1);
                $first = $value;
                $counter = $counter + 1;
                continue;
            }*/

            if ($counter == 1) {
                $student_id = substr($key, strpos($key, '_') + 1);
                $gradeArr[$x] = [
                    'student_id' => $student_id,
                    'grade' => $value
                ];
                $x = $x + 1;
                $counter = 1;
                continue;
            }

            /*if ($counter == 3) {
                $gradeArr[$x] = [
                    'student_id' => $student_id,
                    'first' => $first,
                    'second' => $second,
                    'third' => $value
                ];
                $x = $x + 1;
                $counter = 1;
                continue;
            }*/
        }

        $gradeArr = json_decode(json_encode($gradeArr));
        
        foreach ($gradeArr as $row) {
            $gradeE = Grade::where([['section_id', $section_id], ['subject_id', $subject_id], ['teacher_id', $teacher_id], ['student_id', $row->student_id]])->first();
            if ($gradeE === null || $gradeE == '') { 
                // if not exist create new
                $grade = New Grade;
                $grade->section_id = $section_id;
                $grade->subject_id = $subject_id;
                $grade->teacher_id = $teacher_id;
                $grade->student_id = $row->student_id;
                $grade->grade = $row->grade== '' ? null:$row->grade;
                $grade->save();
            } else {
                // else update
                $gradeE->section_id = $section_id;
                $gradeE->subject_id = $subject_id;
                $gradeE->teacher_id = $teacher_id;
                $gradeE->student_id = $row->student_id;
                $gradeE->grade = $row->grade== '' ? null:$row->grade;
                $gradeE->save(); 
            }
        }

        // show a success message
        Session::flash('success', 'success');

        return redirect()->route('teacher.section.subject', [$section_id, $subject_id]);
    }

    public function information() {
        // block other user to access teacher module
        if(Auth::guard('teacher')->check() != 1) {
            return redirect()->back();
        }

        return view('teacher.information');
    }

    public function informationUpdate(Request $request) {
        // block other user to access teacher module
        if(Auth::guard('teacher')->check() != 1) {
            return redirect()->back();
        }

        $this->validate($request, [
            'contact' => 'max:191',
            'address1' => 'max:191',
            'address2' => 'max:191',
            'barangay' => 'max:191',
            'municipality' => 'max:191',
            'province' => 'max:191'
        ]);

        $teacher = Teacher::find(Auth::guard('teacher')->user()->id);
        $teacher->contact = $request->contact;
        $teacher->address1 = $request->address1;
        $teacher->address2 = $request->adrress2;
        $teacher->barangay = $request->barangay;
        $teacher->municipality = $request->municipality;
        $teacher->province = $request->province;
        $teacher->save();


        // show a success message
        Session::flash('success', 'success');

        return redirect()->route('teacher.information');
    }

    public function password() {
        // block other user to access teacher module
        if(Auth::guard('teacher')->check() != 1) {
            return redirect()->back();
        }

        return view('teacher.password');
    }

    public function passwordUpdate(Request $request) {
        // block other user to access teacher module
        if(Auth::guard('teacher')->check() != 1) {
            return redirect()->back();
        }

        if (Hash::check($request->oldpassword, Auth::guard('teacher')->user()->password)) {
            if ($request->newpassword != $request->newpasswordconfirmation) {
                Session::flash('error', 'New password and confirmation password does not match.');
                return redirect()->back();
            } else {
                $teacher = Teacher::find(Auth::guard('teacher')->user()->id);
                $teacher->password = bcrypt($request->newpassword);
                $teacher->save();

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

    public function gradesPdf($section_id, $student_id)
    {
        // block other user to access student module
        if(Auth::guard('teacher')->check() != 1) {
            return redirect()->back();
        }
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_student_grades_to_html($section_id, $student_id));
        return $pdf->stream();
    }

    function convert_student_grades_to_html($selectedSectionId, $selectedStudentId)
    {
        // block other user to access student module
        if(Auth::guard('teacher')->check() != 1) {
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
                            ['student_id', '=', $selectedStudentId]
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
        $student = Student::find($selectedStudentId);

        $output = '<h2>'.$student->firstname.' '.$student->middlename.' '.$student->lastname.'</h2>
                   <h3>'.$sectionArr['year_level'].' - '.$sectionArr['name'].'</h3>
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
