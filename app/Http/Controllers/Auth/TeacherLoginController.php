<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;

class TeacherLoginController extends Controller
{
	public function __construct() {
		$this->middleware('guest:teacher', ['except' => ['teacherLogout']]);
	}

    public function showLoginForm() {
        // under maintenance
        // return redirect()->route('landing'); 
        
        if(Auth::guard('teacher')->check()){
            return redirect('/teacher'); 
        }
        elseif(Auth::guard('student')->check()){
            return redirect('/student'); 
        }
        elseif(Auth::guard()->check()){
            return redirect('/admin'); 
        }
        else {
            return view('teachers.login');
        }
    	//return view('teachers.login');
    }

    public function login(Request $request) {
    	$this->validate($request, [
    		'id' => 'required',
    		'password' => 'required|min:6'
    	]);

        if (Auth::guard('teacher')->attempt(['employee_id' => $request->id, 'password' => $request->password])) {
           return redirect()->route('teacher.dashboard');
        } else {
            Session::flash('userNotFound', 'Invalid id/password');
        }

    	return redirect()->back()->withInput($request->only('id', 'remember'));
    }

    public function teacherLogout() { 
        // Auth::guard('teacher')->logout();
        Session::flush();
        // Auth::guard('teacher')->logout();

        return redirect()->route('teacher.login');
    }

    
}
