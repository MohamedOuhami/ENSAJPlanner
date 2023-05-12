<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use App\Section;
use App\Timetable;
use App\TeacherRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();

        return view('admin.sections.index', compact('sections'));
    }

    // Creating a new section manually

    public function create()
    {
        return view('admin.sections.create');
    }

    // Setting up the store function
    public function store(Request $request)
    {

        $section = Section::create($request->all());

        return redirect()->route('admin.sections.index');
    }

    // Creating new sections automatically

    public function createauto()
    {
        // Add your logic for creating new sections automatically here
        return view('admin.sections.createauto');
    }

    public function storeauto(Request $request)
    {
        // Fetch all of the students 
        
        // Returning the number of sections to make
        $nbr_max = $request->get('nbr_max');
        $semester = $request->get('semester');


        
        $students_ids = TeacherRole::where('role_id',4)->pluck('user_id')->toArray();
        $students = User::whereIn('id',$students_ids)->where('Semester',$semester)->orderBy('name', 'asc')->get();
        
        $nbr_sections = ceil($students->count() / $nbr_max);

        
        // Creating new sections accordingly to the nbr_max of students

        $section_key = [
            '0' => 'A',
            '1' => 'B',
            '2' => 'C',
            '3' => 'D'
        ];


        for($i=0; $i < $nbr_sections;$i++){

            $section = new Section();
            $section->intitule = 'Section '.$section_key[$i];
            $section->semester = $semester;

            $section->save();

        }

        // Setting the groups of the students
        $sections = Section::where('Semester',$semester)->get(); // Fetch only the required groups
        $chunkSize = max(1, ceil($students->count() / $sections->count())); // Calculate chunk size

        $chunks = $students->chunk($chunkSize); // Use Laravel's built-in chunk method

        $i = 0;

        foreach ($chunks as $chunk) {
            $students = User::whereIn('id', $chunk->pluck('id')->toArray())->get();

            foreach ($students as $student) {
                $student->section_id = $sections[$i]['id'];
                $student->save();
            }
            $i++;
        }

        return redirect()->route('admin.sections.index');

    }


    public function clearsections()
    {
        $students_ids = TeacherRole::where('role_id', 4)->pluck('user_id')->toArray();

        // Update group_id to null for associated students
        User::whereIn('id', $students_ids)->update(['section_id' => null]);

        // Delete all groups without resetting primary key
        Section::query()->delete();

        return redirect()->route('admin.sections.index');
    }


    public function edit(Section $section)
    {

        return view('admin.sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $section->update($request->all());

        return redirect()->route('admin.sections.index');
    }

    public function destroy(Section $section)
    {

        $section->delete();

        return back();
    }

    public function massDestroy(Section $section)
    {
        Section::whereIn('id', request('ids'))->delete();

        return back();
    }
}