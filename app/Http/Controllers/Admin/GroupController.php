<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Group;
use App\Section;
use App\TeacherRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('school_class_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groups = Group::all();
        $sections = Section::all();

        return view('admin.groups.index', compact('groups', 'sections'));
    }

    public function show()
    {
        return;
    }
    public function create()
    {
        abort_if(Gate::denies('school_class_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $groups = Group::all();
        $sections = Section::all();

        return view('admin.groups.create', compact('groups', 'sections'));
    }

    public function store(Request $request)
    {
        $group = Group::create($request->all());

        return redirect()->route('admin.groups.index');
    }

    public function createauto()
    {
        // Add your logic for creating new sections automatically here

        $sections = Section::all();
        return view('admin.groups.createauto', compact('sections'));
    }

    public function storeauto(Request $request)
    {
        // Fetch all of the students 

        $sections = Section::all();

        foreach($sections as $section){

            $students_ids = TeacherRole::where('role_id', 4)->pluck('user_id')->toArray();
            $students = User::whereIn('id', $students_ids)
            ->where('section_id',$section->id)
            ->orderBy('name', 'asc')
            ->get();
    
            // Returning the number of sections to make
            $nbr_max = $request->get('nbr_max');
            $nbr_groups = ceil($students->count() / $nbr_max);
    
            // Creating new groups accordingly to the nbr_max of students
            for ($i = 1; $i <= $nbr_groups; $i++) {
                $group = new Group();
                $group->intitule = 'Groupe ' . $i;
                $group->section_id = $section->id;
                $group->save();
            }
    
            // Setting the groups of the students
            $groups = Group::query()->limit($nbr_groups)->get(); // Fetch only the required groups
            if($groups->count() > 0 ){

                $chunkSize = max(1, ceil($students->count() / $groups->count())); // Calculate chunk size
        
                $chunks = $students->chunk($chunkSize); // Use Laravel's built-in chunk method
        
                $i = 0;
        
                foreach ($chunks as $chunk) {
                    $students = User::whereIn('id', $chunk->pluck('id')->toArray())->get();
        
                    foreach ($students as $student) {
                        $student->group_id = $groups[$i]['id'];
                        $student->save();
                    }
                    $i++;
                }
            }
        }

        return redirect()->route('admin.groups.index');
    }


    public function cleargroups()
    {
        $students_ids = TeacherRole::where('role_id', 4)->pluck('user_id')->toArray();

        // Update group_id to null for associated students
        User::whereIn('id', $students_ids)->update(['group_id' => null]);

        // Delete all groups without resetting primary key
        Group::query()->delete();

        return redirect()->route('admin.groups.index');
    }


    public function destroy(Group $group)
    {
        abort_if(Gate::denies('school_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $group->delete();

        return back();
    }

    public function edit(Group $group)
    {
        $sections = Section::all();
        return view('admin.groups.edit', compact('group', 'sections'));
    }

    public function update(Request $request, Group $group)
    {
        $group->update($request->all());

        return redirect()->route('admin.groups.index');
    }
}