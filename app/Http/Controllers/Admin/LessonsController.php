<?php

namespace App\Http\Controllers\Admin;

use App\LessonGroup;
use Gate;
use App\User;
use App\Group;
use App\Salle;
use App\Lesson;
use App\Section;
use App\Timetable;
use App\SchoolClass;
use Illuminate\Http\Request;
use phpseclib3\File\ASN1\Element;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyLessonRequest;

class LessonsController extends Controller
{
    public function index(Request $request)
    {

        abort_if(Gate::denies('lesson_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timetable_id = $request->input("timetable_id");
        $timetable = DB::table('timetables')
            ->where('id', $timetable_id)->get();

        $lessons = Lesson::where('timetable_id', $timetable_id)->get();


        return view('admin.lessons.index', compact('lessons', 'timetable_id', 'timetable'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('lesson_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teacher = DB::table('users')
            ->where('id', auth()->user()->id)->get()[0];


        $type = $request->input('type');

        $timetableId = $request->input('id');
        $timetable = DB::table('timetables')
            ->where('id', $timetableId)->get()[0];


        $section_id = (string) $timetable->section_id;
        $section = DB::table('sections')
            ->where('id', $section_id)->get()[0];

        $salles = Salle::all();
        $schoolClasses = SchoolClass::all();


        return view('admin.lessons.create', compact('classes', 'type', 'timetableId', 'teacher', 'salles', 'section', 'timetable', 'schoolClasses'));
    }

    public function store(Request $request)
    {

        // dd($request->input('salle_id'));
        $validatedData = $request->validate([
            'weekday' => 'required',
            'salle_id' => 'required',
            'code_matiere' => 'required',
            'type' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'teacher_id' => 'required',
            'timetable_id' => 'required',
        ]);

        Lesson::create([
            'weekday' => $validatedData['weekday'],
            'salle_id' => $validatedData['salle_id'],
            'code_matiere' => $validatedData['code_matiere'],
            'type' => $validatedData['type'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'teacher_id' => $validatedData['teacher_id'],
            'timetable_id' => $validatedData['timetable_id'],
        ]);

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson created successfully.');
    }

    public function storeauto(Request $request, $timetable_id)
    {


        $timetable = Timetable::find($timetable_id);
        $section = $timetable->section;
        $groupCount = $section->groups()->count();

        if ($timetable) {
            $elements = SchoolClass::whereHas('module', function ($query) use ($timetable) {
                $query->where('semester', $timetable->section->Semester);
            })->get();


        } else {
            dd("Could not find timetable");
        }

        // Days

        $day = 1;

        $start_hour = date('H:i', strtotime('08:00'));
        $end_hour = date('H:i', strtotime($start_hour . '+2 hours'));
        $lunch_hour = date('H:i', strtotime('12:30'));
        $last_hour = date('H:i', strtotime('17:30'));

        // Looping through all of the elements and set a seance of 2 hour followed by another seance

        $elements = $elements->shuffle();

        $lessons_arr = [];

        $salles = null;
        foreach ($elements as $element) {

            // Reading how many seances, I have

            $occ_per_week_cours = $element->occ_per_week_Cours;
            $occ_per_week_td = $element->occ_per_week_TD;
            $occ_per_week_tp = $element->occ_per_week_TP;

            // Cours
            for ($i = 0; $i < $occ_per_week_cours; $i++) {

                if ($start_hour == $lunch_hour) {

                    $start_hour = date('H:i', strtotime('13:00'));
                    $end_hour = date('H:i', strtotime($start_hour . '+2 hours'));

                }
                if ($start_hour == $last_hour) {

                    $start_hour = date('H:i', strtotime('08:00'));
                    $end_hour = date('H:i', strtotime($start_hour . '+2 hours'));
                    $day++;

                }

                // Add the new lesson to the table
                $lesson = Lesson::create([
                    // 'weekday' => $day,
                    // 'salle_id' => $salles->id,
                    'code_matiere' => $element->id,
                    'type' => "Cours",
                    // 'start_time' => $start_hour,
                    // 'end_time' => $end_hour,
                    // 'teacher_id' => 2,
                    'timetable_id' => $timetable_id,
                ]);

                array_push($lessons_arr, $lesson);
                // $lesson->save();

                $start_hour = date('H:i', strtotime($end_hour . '+15 minutes'));
                $end_hour = date('H:i', strtotime($start_hour . '+2 hours'));
            }

            // TD

            $groups = $section->groups;

            for ($i = 0; $i < $occ_per_week_td; $i++) {

                foreach($groups as $group){
                    
                    if ($start_hour == $lunch_hour) {
    
                        $start_hour = date('H:i', strtotime('13:00'));
                        $end_hour = date('H:i', strtotime($start_hour . '+2 hours'));
    
                    }
                    if ($start_hour == $last_hour) {
    
                        $start_hour = date('H:i', strtotime('08:00'));
                        $end_hour = date('H:i', strtotime($start_hour . '+2 hours'));
                        $day++;
    
                    }
    
                    // Add the new lesson to the table
                    $lesson = Lesson::create([
                        // 'weekday' => $day,
                        // 'salle_id' => $salles->id,
                        'code_matiere' => $element->id,
                        'type' => "TD",
                        // 'start_time' => $start_hour,
                        // 'end_time' => $end_hour,
                        // 'teacher_id' => 2,
                        'timetable_id' => $timetable_id,
                    ]);

                    LessonGroup::create([
                        'lesson_id' => $lesson->id,
                        'group_id' => $group->id,
                    ]);
                 
                    
    
                    
    
                    array_push($lessons_arr, $lesson);
                    // $lesson->save();
    
                    $start_hour = date('H:i', strtotime($end_hour . '+15 minutes'));
                    $end_hour = date('H:i', strtotime($start_hour . '+2 hours'));
                }

            }
            // TP
            for ($i = 0; $i < $occ_per_week_tp; $i++) {

                if ($start_hour == $lunch_hour) {

                    $start_hour = date('H:i', strtotime('13:00'));
                    $end_hour = date('H:i', strtotime($start_hour . '+2 hours'));

                }
                if ($start_hour == $last_hour) {

                    $start_hour = date('H:i', strtotime('08:00'));
                    $end_hour = date('H:i', strtotime($start_hour . '+2 hours'));
                    $day++;

                }

                // Add the new lesson to the table
                $lesson = Lesson::create([
                    // 'weekday' => $day,
                    // 'salle_id' => $salles->id,
                    'code_matiere' => $element->id,
                    'type' => "TP",
                    // 'start_time' => $start_hour,
                    // 'end_time' => $end_hour,
                    // 'teacher_id' => 2,
                    'timetable_id' => $timetable_id,
                ]);

                array_push($lessons_arr, $lesson);
                // $lesson->save();

                $start_hour = date('H:i', strtotime($end_hour . '+15 minutes'));
                $end_hour = date('H:i', strtotime($start_hour . '+2 hours'));
            }

        }

        // Convert lessons array to JSON
        $lessons_json = json_encode($lessons_arr);

        // Save JSON to a file
        $file_name = 'lessons.json';
        $file_path = __DIR__ . '/' . $file_name; // Specify the full file path
        file_put_contents($file_path, $lessons_json);

        $lessons = collect($lessons_arr);



        $lessons = $lessons->shuffle();
        foreach ($lessons as $lesson) {
            $lesson->save();
        }


        return redirect()->route('admin.lessons.index', ['timetable_id' => $timetable->id])->with('success', 'Lesson created successfully.');
    }


    public function edit(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');


        return view('admin.lessons.edit', compact('classes', 'lesson'));
    }

    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->all());

        return redirect()->route('admin.lessons.index', ['timetable_id' => $lesson->timetable->id]);
    }

    public function show(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lesson->load('class', 'teacher');

        return view('admin.lessons.show', compact('lesson'));
    }

    public function destroy(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lesson->delete();

        return back();
    }

    public function massDestroy(MassDestroyLessonRequest $request)
    {
        Lesson::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}