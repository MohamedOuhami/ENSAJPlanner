<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    $routeName = auth()->user() && (auth()->user()->is_student || auth()->user()->is_teacher) ? 'admin.calendar.index' : 'admin.home';
    if (session('status')) {
        return redirect()->route($routeName)->with('status', session('status'));
    }

    return redirect()->route($routeName);
});

Auth::routes(['register' => false]);
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Lessons
    Route::delete('lessons/destroy', 'LessonsController@massDestroy')->name('lessons.massDestroy');
    Route::get('lessons/storeauto/{timetable_id}','LessonsController@storeauto')->name('lessons.storeauto');
    Route::get('lessons', 'LessonsController@index')->name('lessons.index');

    Route::resource('lessons', 'LessonsController');

    // School Classes
    Route::delete('school-classes/destroy', 'SchoolClassesController@massDestroy')->name('school-classes.massDestroy');
    Route::resource('school-classes', 'SchoolClassesController');

    // Modules
    Route::resource('modules', 'ModuleController');

    // Sections
    Route::delete('sections/destroy', 'SectionController@massDestroy')->name('sections.massDestroy');
    Route::get('sections/createauto','SectionController@createauto')->name('sections.createauto');
    Route::post('sections/storeauto','SectionController@storeauto')->name('sections.storeauto');
    Route::get('sections/cleargroups','SectionController@clearsections')->name('sections.cleargroups');
    Route::resource('sections', 'SectionController');

    // Groupes 
    Route::get('groups/createauto','GroupController@createauto')->name('groups.createauto');
    Route::post('groups/storeauto','GroupController@storeauto')->name('groups.storeauto');
    Route::get('groups/cleargroups','GroupController@cleargroups')->name('groups.cleargroups');
    Route::resource('groups', 'GroupController');

    // Salles 
    Route::resource('salles', 'SalleController');

    // Timetables
    Route::resource('timetables', 'TimetableController');

    // Timetables Optimizer
    Route::get('timetableoptimizer', 'TimetableOptimizerController@index')->name('timetableoptimizer.index');
    Route::get('timetableoptimizer/{seconds}/create','TimetableOptimizerController@create')->name('timetableoptimizer.create');

    // Timetable-Teacher
    // Route::resource('teachertimetables', 'TeacherTimetableController');
    Route::get('teachertimetables/{timetable_id}', 'TeacherTimetableController@index')->name('teachertimetables.index');
    Route::get('teachertimetables/{timetable_id}/create', 'TeacherTimetableController@create')->name('teachertimetables.create');
    Route::post('teachertimetables/{timetable_id}', 'TeacherTimetableController@store')->name('teachertimetables.store');

    // Lesson-Group
    Route::get('lessongroup/{lesson_id}', 'LessonGroupController@index')->name('lessongroup.index');
    Route::get('lessongroup/{lesson_id}/create', 'LessonGroupController@create')->name('lessongroup.create');
    Route::post('lessongroup/{lesson_id}', 'LessonGroupController@store')->name('lessongroup.store');

    // Lesson-Professor
    Route::get('lessonprofessors/{lesson_id}', 'LessonProfessorController@index')->name('lessonprofessors.index');
    Route::get('lessonprofessors/{lesson_id}/create', 'LessonProfessorController@create')->name('lessonprofessors.create');
    Route::post('lessonprofessors/{lesson_id}', 'LessonProfessorController@store')->name('lessonprofessors.store');

    Route::get('calendar', 'CalendarController@index')->name('calendar.index');
    Route::get('calendar/all', 'CalendarController@indexall')->name('calendar.indexall');

    


});