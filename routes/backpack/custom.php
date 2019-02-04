<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

	Route::get('dashboard', 'AdminDashboardController@dashboard')->name('admin.dashboard');
	Route::get('/', 'AdminDashboardController@redirect')->name('backpack');

	CRUD::resource('year', 'YearCrudController');
	CRUD::resource('academicyear', 'AcademicYearCrudController');
	CRUD::resource('subject', 'SubjectCrudController');
	Route::post('teacher/resetpassword/{id}', 'TeacherCrudController@teacherResetPassword')->name('teacher.reset.password');
	CRUD::resource('teacher', 'TeacherCrudController');
	/*Route::get('student/uploadcsv', 'StudentCrudController@uploadCsv')->name('student.csv');
	Route::post('student/uploadcsv', 'StudentCrudController@submitCsv')->name('student.upload.csv');*/
	Route::post('student/resetpassword/{id}', 'StudentCrudController@studentResetPassword')->name('student.reset.password');
	CRUD::resource('student', 'StudentCrudController');

	Route::get('download-students', 'StudentCrudController@downloadStudents');

	Route::get('section/{id}/addteachers', 'SectionCrudController@addTeachers')->name('section.teachers');
	/*Route::match(['PUT', 'PATCH'], 'section/{id}/addteachers', 'SectionCrudController@addTeacherOnSubject')->name('section.teachers.update');*/
	Route::post('section/{id}/addteacherss', 'SectionCrudController@addTeacherOnSubject')->name('section.teachers.update');
	Route::get('section/{id}/students', 'SectionCrudController@viewStudents')->name('section.students.view');
	Route::get('academicyear/{id}/sections', 'AdminDashboardController@viewAcademicYearSection')->name('academic.section');

	CRUD::resource('section', 'SectionCrudController');
	CRUD::resource('facility', 'FacilityCrudController');
	CRUD::resource('administration', 'AdministrationCrudController');
	CRUD::resource('page_content', 'Page_contentCrudController');
	CRUD::resource('announcement', 'AnnouncementCrudController');

	// carousel routes
	Route::get('carousels', 'CarouselController@index')->name('carousel.index');
	Route::get('carousels/create', 'CarouselController@create')->name('carousel.create');
	Route::post('carousels/create', 'CarouselController@store')->name('carousel.store');
	Route::get('carousels/{id}/edit', 'CarouselController@edit')->name('carousel.edit');
	Route::match(['PUT', 'PATCH'], 'carousels/{id}/edit', 'CarouselController@update')->name('carousel.update');
	Route::delete('carousels/{id}/delete', 'CarouselController@destroy')->name('carousel.destroy');

	// logo routes
	Route::get('logos', 'LogoController@index')->name('logo.index');
	Route::get('logos/create', 'LogoController@create')->name('logo.create');
	Route::post('logos/create', 'LogoController@store')->name('logo.store');
	Route::get('logos/{id}/edit', 'LogoController@edit')->name('logo.edit');
	Route::match(['PUT', 'PATCH'], 'logos/{id}/edit', 'LogoController@update')->name('logo.update');
	Route::delete('logos/{id}/delete', 'LogoController@destroy')->name('logo.destroy');

	// schoolname routes
	Route::get('schoolnames', 'SchoolnameController@index')->name('schoolname.index');
	Route::get('schoolnames/create', 'SchoolnameController@create')->name('schoolname.create');
	Route::post('schoolnames/create', 'SchoolnameController@store')->name('schoolname.store');
	Route::get('schoolnames/{id}/edit', 'SchoolnameController@edit')->name('schoolname.edit');
	Route::match(['PUT', 'PATCH'], 'schoolnames/{id}/edit', 'SchoolnameController@update')->name('schoolname.update');
	Route::delete('schoolnames/{id}/delete', 'SchoolnameController@destroy')->name('schoolname.destroy');

	// about routes
	Route::get('abouts', 'AboutController@index')->name('about.index');
	Route::get('abouts/create', 'AboutController@create')->name('about.create');
	Route::post('abouts/create', 'AboutController@store')->name('about.store');
	Route::get('abouts/{id}/edit', 'AboutController@edit')->name('about.edit');
	Route::match(['PUT', 'PATCH'], 'abouts/{id}/edit', 'AboutController@update')->name('about.update');
	Route::delete('abouts/{id}/delete', 'AboutController@destroy')->name('about.destroy');

	// inbox routes
	Route::get('messages', 'MessageController@index')->name('message.index');
	Route::get('messages/show', 'MessageController@show')->name('message.show');
	Route::delete('messages/{id}/delete', 'MessageController@destroy')->name('message.destroy');
	Route::delete('messages/delete', 'MessageController@destroyAll')->name('message.destroy.all');

	// user routes
	Route::get('users', 'UserController@index')->name('user.index');
	Route::get('users/create', 'UserController@create')->name('user.create');
	Route::post('users/create', 'UserController@store')->name('user.store');
	Route::get('users/{id}/edit', 'UserController@edit')->name('user.edit');
	Route::match(['PUT', 'PATCH'], 'users/{id}/edit', 'UserController@update')->name('user.update');
	Route::delete('users/{id}/delete', 'UserController@destroy')->name('user.destroy');
	// get users online
	Route::get('users/online', 'UserController@getOnlineUsers')->name('users.online');

	// user routes
	Route::get('logs', 'LogController@index')->name('log.index');
	Route::delete('logs/{id}/delete', 'LogController@destroy')->name('log.destroy');
	Route::delete('logs/delete', 'LogController@destroyAll')->name('log.destroy.all');

	// album routes
	Route::get('albums', 'AlbumController@index')->name('album.index');
	Route::get('albums/create', 'AlbumController@create')->name('album.create');
	Route::post('albums/create', 'AlbumController@store')->name('album.store');
	Route::get('albums/{id}', 'AlbumController@show')->name('album.show');
	Route::get('albums/{id}/edit', 'AlbumController@edit')->name('album.edit');
	Route::match(['PUT', 'PATCH'], 'albums/{id}/edit', 'AlbumController@update')->name('album.update');
	Route::delete('albums/{id}/delete', 'AlbumController@destroy')->name('album.destroy');

	// schoolyear routes
	Route::get('schoolyears', 'SchoolYearController@index')->name('schoolyear.index');
	Route::get('schoolyears/create', 'SchoolYearController@create')->name('schoolyear.create');
	Route::post('schoolyears/create', 'SchoolYearController@store')->name('schoolyear.store');
	Route::get('schoolyears/{id}', 'SchoolYearController@show')->name('schoolyear.show');
	Route::get('schoolyears/{id}/edit', 'SchoolYearController@edit')->name('schoolyear.edit');
	Route::match(['PUT', 'PATCH'], 'schoolyears/{id}/edit', 'SchoolYearController@update')->name('schoolyear.update');
	Route::delete('schoolyears/{id}/delete', 'SchoolYearController@destroy')->name('schoolyear.destroy');

	// track routes
	Route::get('tracks/downloadall', 'TrackController@downloadAll')->name('track.download');
	Route::get('tracks', 'TrackController@index')->name('track.index');
	Route::get('tracks/create', 'TrackController@create')->name('track.create');
	Route::post('tracks/create', 'TrackController@store')->name('track.store');
	Route::get('tracks/{id}', 'TrackController@show')->name('track.show');
	Route::get('tracks/{id}/edit', 'TrackController@edit')->name('track.edit');
	Route::match(['PUT', 'PATCH'], 'tracks/{id}/edit', 'TrackController@update')->name('track.update');
	Route::delete('tracks/{id}/delete', 'TrackController@destroy')->name('track.destroy');

	// subject routes
	Route::get('subjects', 'SubjectController@index')->name('subject.index');
	Route::get('subjects/create', 'SubjectController@create')->name('subject.create');
	Route::post('subjects/create', 'SubjectController@store')->name('subject.store');
	Route::get('subjects/{id}', 'SubjectController@show')->name('subject.show');
	Route::get('subjects/{id}/edit', 'SubjectController@edit')->name('subject.edit');
	Route::match(['PUT', 'PATCH'], 'subjects/{id}/edit', 'SubjectController@update')->name('subject.update');
	Route::delete('subjects/{id}/delete', 'SubjectController@destroy')->name('subject.destroy');

	// teacher routes
	Route::post('teachers/v-import', 'TeacherController@cImport')->name('teacher.c-import');
	Route::get('teachers/v-import', 'TeacherController@vImport')->name('teacher.v-import');
	Route::get('teachers/downloadtemplate', 'TeacherController@downloadTemplate')->name('teacher.downloadtemplate');

	Route::get('teachers', 'TeacherController@index')->name('teacher.index');
	Route::get('teachers/create', 'TeacherController@create')->name('teacher.create');
	Route::post('teachers/create', 'TeacherController@store')->name('teacher.store');
	Route::get('teachers/{id}', 'TeacherController@show')->name('teacher.show');
	Route::get('teachers/{id}/edit', 'TeacherController@edit')->name('teacher.edit');
	Route::match(['PUT', 'PATCH'], 'teachers/{id}/edit', 'TeacherController@update')->name('teacher.update');
	Route::match(['PUT', 'PATCH'], 'teachers/{id}/resetpassword', 'TeacherController@resetPassword')->name('teacher.resetpassword');
	Route::delete('teachers/{id}/delete', 'TeacherController@destroy')->name('teacher.destroy');

	// student routes
	Route::post('students/v-import', 'studentController@cImport')->name('student.c-import');
	Route::get('students/v-import', 'studentController@vImport')->name('student.v-import');
	Route::get('students/downloadtemplate', 'studentController@downloadTemplate')->name('student.downloadtemplate');

	Route::get('students', 'StudentController@index')->name('student.index');
	Route::get('students/create', 'StudentController@create')->name('student.create');
	Route::post('students/create', 'StudentController@store')->name('student.store');
	Route::get('students/{id}', 'StudentController@show')->name('student.show');
	Route::get('students/{id}/edit', 'StudentController@edit')->name('student.edit');
	Route::match(['PUT', 'PATCH'], 'students/{id}/edit', 'StudentController@update')->name('student.update');
	Route::match(['PUT', 'PATCH'], 'students/{id}/resetpassword', 'StudentController@resetPassword')->name('student.resetpassword');
	Route::delete('students/{id}/delete', 'StudentController@destroy')->name('student.destroy');

	// section routes
	// Route::get('sections/downloadall', 'SectionController@downloadAll')->name('section.download');
	Route::get('sections/{id}/students', 'SectionController@createStudent')->name('section.student.create');
	Route::post('sections/{id}/students', 'SectionController@storeStudent')->name('section.student.store');
	Route::get('sections/{id}/subjects-teachers', 'SectionController@createSubjectTeacher')->name('section.subject-teacher.create');
	Route::post('sections/{id}/subjects-teachers', 'SectionController@storeSubjectTeacher')->name('section.subject-teacher.store');
	Route::get('sections', 'SectionController@index')->name('section.index');
	Route::get('sections/create', 'SectionController@create')->name('section.create');
	Route::post('sections/create', 'SectionController@store')->name('section.store');
	Route::get('sections/{id}', 'SectionController@show')->name('section.show');
	Route::get('sections/{id}/edit', 'SectionController@edit')->name('section.edit');
	Route::match(['PUT', 'PATCH'], 'sections/{id}/edit', 'SectionController@update')->name('section.update');
	Route::delete('sections/{id}/delete', 'SectionController@destroy')->name('section.destroy');

	//  grade settings route
	Route::get('grades/settings', 'GradeController@index')->name('grade.settings.index');
	Route::match(['PUT', 'PATCH'], 'grades/activation', 'GradeController@activation')->name('grade.settings.activation');

	// maintenance route
	// Route::get('oops', 'MaintenaceController@oops')->name('oops');

}); // this should be the absolute last line of this file
