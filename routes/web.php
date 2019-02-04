<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/phpinfo', function() {
    return phpinfo();
});

Route::get('/login', function() {
	return redirect()->route('student.login');
});

Route::get('/facilities','PageController@facilityPage')->name('facilities');
Route::get('/albums','PageController@albumPage')->name('albums');
Route::get('/albums/{id}/images','PageController@albumImagesPage')->name('album.images');
Route::get('/announcements','PageController@announcementPage')->name('announcements');
Route::get('/administrations','PageController@administrationPage')->name('administrations');
Route::get('/','HomeController@landingpage')->name('landing');


// Admin Login
Route::get('/admin/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');
Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/admin', 'Auth\AdminLoginController@redirect')->name('redirect-admin-login');


//Auth::routes();
// Authentication Routes...
	// $this->get('/login', 'Auth\LoginController@showLoginForm')->name('login');
	// $this->post('/login', 'Auth\LoginController@login');
	// $this->post('/logout', 'Auth\LoginController@logout')->name('logout');

	// // Registration Routes...
	// $this->get('/naNljDFJvX', 'Auth\RegisterController@showRegistrationForm')->name('register');
	// $this->post('/naNljDFJvX', 'Auth\RegisterController@register');

	// Password Reset Routes...
	$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	 $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	$this->get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	$this->post('password/reset', 'Auth\ResetPasswordController@reset');

// Route::get('/home', 'HomeController@index')->name('home');
Route::post('message/create', 'MessageController@store')->name('message.store');
// student routes
Route::get('/student/login', 'Auth\StudentLoginController@showLoginForm')->name('student.login');
Route::post('/student/login', 'Auth\StudentLoginController@login')->name('student.login.submit');
Route::get('/student/logout', 'Auth\StudentLoginController@studentLogout')->name('student.logout');
Route::get('/student/classes', 'Student\SectionController@classes')->name('student.classes');
Route::get('/student/class/{id}', 'Student\SectionController@class')->name('student.class');

Route::get('/student/information', 'Student\SectionController@information')->name('student.information');
Route::post('/student/information', 'Student\SectionController@informationUpdate')->name('student.information.submit');
Route::get('/student/password', 'Student\SectionController@password')->name('student.password');
Route::post('/student/password', 'Student\SectionController@passwordUpdate')->name('student.password.submit');
Route::get('/student/grades/pdf/{selectedSection}', 'Student\SectionController@gradesPdf')->name('student.grades.pdf');
/*Route::get('/student/account', 'StudentController@viewAccountSettings')->name('student.view.account');
Route::post('/student/updatepicture', 'StudentController@updatePicture')->name('student.update.picture');
Route::post('/student/updateinfo', 'StudentController@updateInfo')->name('student.update.info');
Route::match(['PUT', 'PATCH'], 'student/updatepassword/{id}', 'StudentController@updatePassword')->name('student.update.password');

Route::get('/studentsections', 'Student\GradeController@studentSections')->name('student.sections');
Route::get('/studentsections/{id}/grades', 'Student\GradeController@studentGrades')->name('student.grades');*/






// teacher routes
Route::get('/teacher/login', 'Auth\TeacherLoginController@showLoginForm')->name('teacher.login');
Route::post('/teacher/login', 'Auth\TeacherLoginController@login')->name('teacher.login.submit');
Route::get('/teacher/classes', 'Teacher\SectionController@dashboard')->name('teacher.dashboard');
Route::get('/teacher/logout', 'Auth\TeacherLoginController@teacherLogout')->name('teacher.logout');
Route::get('/teacher/section/{id}/subjects', 'Teacher\SectionController@sectionSubjects')->name('teacher.section.subjects');
Route::get('/teacher/section/{section_id}/student/{student_id}', 'Teacher\SectionController@sectionStudent')->name('teacher.section.student');
Route::get('/teacher/section/{section_id}/student/{student_id}/pdf', 'Teacher\SectionController@gradesPdf')->name('teacher.section.student.grades.pdf');
Route::get('/teacher/section/{section_id}/subject/{subject_id}', 'Teacher\SectionController@sectionSubject')->name('teacher.section.subject');
Route::get('/teacher/section/{section_id}/subject/{subject_id}/teacher/{teacher_id}/excel', 'Teacher\SectionController@sectionSubjectExcel')->name('teacher.section.subject.excel');
Route::post('/teacher/section/{section_id}/subject/{subject_id}/teacher/{teacher_id}', 'Teacher\SectionController@saveGrades')->name('submit.grade');
Route::get('/teacher/information', 'Teacher\SectionController@information')->name('teacher.information');
Route::post('/teacher/information', 'Teacher\SectionController@informationUpdate')->name('teacher.information.submit');
Route::get('/teacher/password', 'Teacher\SectionController@password')->name('teacher.password');
Route::post('/teacher/password', 'Teacher\SectionController@passwordUpdate')->name('teacher.password.submit');
