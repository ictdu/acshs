<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use Session;
use Auth;
use Image;
use Storage;
use Hash;


class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:student');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('students.dashboard');
    }

    public function viewAccountSettings() {
        return view('students.account-settings');
    }

    public function updatePicture(Request $request)
    {
        $this->validate($request, [
            'profile_picture'          =>        'required|image'
        ]);

        $id = Auth::user()->id;
        $student = Student::find($id);

        //save image
            if($request->hasFile('profile_picture')){
                $image = $request->file('profile_picture');
                $filename = $id . '.' . time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('uploads/student/' . $filename);
                Image::make($image)->save($location);
                $oldImage = $student->image; //old imagename

                $student->image = $filename; 

                Storage::delete($oldImage); //delete old image
             
            }

        $student->save();

        Session::flash('picture-is-in', 'value');
        Session::flash('success', 'Your profile picture has been changed.');

        return redirect()->route('student.view.account');
    }

    public function updateInfo(Request $request)
    {
        
        $this->validate($request, [
            'email'            =>          'required|email|max:255'
        ]);


        $id = Auth::user()->id;
        $student = Student::find($id);

        $student->email = $request->email;

        $student->save();

        Session::flash('info-is-in','value');
        Session::flash('success', 'Email has been changed.');

        return redirect()->route('student.view.account');
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'old_password'         =>       'required',
            'new_password'     =>           'required|string|min:6|confirmed'          
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)) {
            //if current password and new password are same
            if(strcmp($request->get('old_password'), $request->get('new_password')) == 0) {
                Session::flash('password-is-in', 'haha');
                Session::flash('error', 'New Password cannot be same as your current password. Please choose a different password.');
                return redirect()->route('teacher.view.account');
            }

            $student = Student::find($id);

            $student->password = bcrypt($request->new_password);

            $student->save();

            Session::flash('password-is-in', 'haha');
            Session::flash('success', 'Your password has been successfully changed.');
            return redirect()->route('student.view.account');

        }
        else {
            Session::flash('password-is-in', 'haha');
            Session::flash('error', 'The old password you provided did not match your current password.');
            return redirect()->route('student.view.account');
        }

    }
}
