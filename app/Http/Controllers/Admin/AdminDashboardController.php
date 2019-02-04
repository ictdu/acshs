<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Announcement;
use App\Message;
use App\User;
use App\Student;
use App\Teacher;
use Auth;

class AdminDashboardController extends CrudController
{
	/*public function __construct()
    {
        $this->middleware(backpack_middleware());
    }
*/
    public function dashboard()
    {
        if (Auth::user()->user_type == 2) {
            return redirect('admin/announcement');
        }
        // $user = new User;
        // $onlineUsers = $user->allOnline();
        $inboxes = Message::all();
        $students = Student::all();
        $teachers = Teacher::all();

        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title

        $latest_news = Announcement::orderBy('created_at', 'desc')->first();
        $messages = Message::orderBy('created_at', 'desc')->paginate(5);

        return view('admin-dashboard.dashboard', $this->data)
            ->with('latest_news', $latest_news)
            ->with('students', $students)
            ->with('teachers', $teachers)
            ->with('inboxes', $inboxes)
            ->with('messages', $messages);
    }

    public function viewAcademicYearSection($id) {
    	$ay = AcademicYear::find($id);
    	$sections = Section::all();
    	$years = Year::all();

    	return view('admin-dashboard.academicyear-sections')
    		->with('ay', $ay)
    		->with('sections', $sections)
    		->with('years', $years);
    }

    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect()->route('admin.dashboard');
    }
}
