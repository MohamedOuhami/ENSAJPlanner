<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\TeacherRole;
use App\User;
use App\Timetable;
use App\TeacherTimetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TeacherTimetableController extends Controller
{
    public function index($timetable_id)
    {
        $teacherIds = DB::table('teacher_timetables')
            ->where('timetable_id', $timetable_id)
            ->pluck('teacher_id')
            ->toArray();

        $teachers = User::whereIn('id', $teacherIds)->get();


        return view('admin.teachertimetables.index', compact('teachers', 'timetable_id'));
    }

    public function create($timetable_id)
    {
        $teacher_role = Role::where('Title', 'Teacher')
            ->pluck('id');

        $teachers_ids = TeacherRole::where('role_id', $teacher_role)
            ->pluck('user_id');

        return view('admin.teachertimetables.create', compact('teachers_ids', 'timetable_id'));
    }

    public function store(Request $request, $timetable_id)
    {
        $teacher_ids = $request->all()['teacher_id'];
        // Loop through the teacher_ids and create a new row for each teacher
        foreach ($teacher_ids as $teacher_id) {
            TeacherTimetable::create([
                'teacher_id' => $teacher_id,
                'timetable_id' => $timetable_id,
            ]);
        }
        // dd($request->all()['teacher_id']);

        return redirect()->route('admin.teachertimetables.index', $timetable_id);
    }

}