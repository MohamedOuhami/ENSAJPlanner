<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use App\Group;
use App\Lesson;
use App\Section;
use App\Timetable;
use App\LessonGroup;
use App\TeacherRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LessonProfessorController extends Controller
{
    public function index($lesson_id)
    {

        $teacherIds = DB::table('lessons')
            ->where('id', $lesson_id)
            ->pluck('teacher_id')
            ->toArray();

        $teachers = User::whereIn('id', $teacherIds)->get();


        return view('admin.lessonprofessors.index', compact('teachers', 'lesson_id'));
    }

    public function create($lesson_id)
    {
        $teacher_role = Role::where('Title', 'Teacher')
            ->pluck('id');

        $teacher_ids = TeacherRole::where('role_id', $teacher_role)
            ->pluck('user_id');

        // dd($teacher_ids);

        return view('admin.lessonprofessors.create', compact('teacher_ids', 'lesson_id'));
    }

    public function store(Request $request, $lesson_id)
    {
        $new_teacher_id = $request->all()['teacher_id'];


        // Find the lesson by ID
        $lesson = Lesson::find($lesson_id);

        // Update the teacher_id attribute
        $lesson->teacher_id = $new_teacher_id;

        // Save the changes to the database
        $lesson->save();

        
        // dd($request->all()['teacher_id']);
        $timetable_id = $lesson->timetable_id;

        $lessons = Lesson::where('timetable_id',$timetable_id);

        return redirect()->route('admin.lessons.index', ['timetable_id' => $timetable_id])->with('success', 'Lesson created successfully.');

    }

}