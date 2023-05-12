<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Lesson;
use App\LessonGroup;
use App\Section;
use App\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LessonGroupController extends Controller
{
    public function index($lesson_id)
    {

        $groups_ids = DB::table('lesson_group')
            ->where('lesson_id', $lesson_id)
            ->get()
            ->pluck('group_id');
        // $groups = $lesson->groups;

        $groups = Group::whereIn('id', $groups_ids)->get();




        return view('admin.lessongroups.index', compact('groups', 'lesson_id'));
    }

    public function create($lesson_id)
    {
        $lesson = Lesson::find($lesson_id);
        $timetable = Timetable::where('id', $lesson->timetable_id)->first();
        $section = Section::where('id', $timetable->section_id)->pluck('id');

        $group_ids = Group::where('section_id', $section)
            ->pluck('id');

        return view('admin.lessongroups.create', compact('group_ids', 'lesson_id'));
    }

    public function store(Request $request, $lesson_id)
    {

        $lesson = Lesson::find($lesson_id);
        $group_id = $request->all()['group_id'];
        // Loop through the teacher_ids and create a new row for each teacher
        
            LessonGroup::create([
                'group_id' => $group_id,
                'lesson_id' => $lesson_id,
            ]);

        // dd($request->all()['teacher_id']);
        $timetable_id = $lesson->timetable_id;

        return redirect()->route('admin.lessons.index', ['timetable_id' => $timetable_id])->with('success', 'Lesson created successfully.');
    }

}