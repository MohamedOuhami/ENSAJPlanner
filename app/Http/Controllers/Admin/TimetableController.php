<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Role;
use App\User;
use App\Section;
use App\Timetable;
use App\TeacherRole;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Facade\FlareClient\Http\Response;

class TimetableController extends Controller
{
    public function index()
    {
        // The current user
        $user = auth()->user();

        // If the user is an admin, show him all the timetables
        $user_role_id = TeacherRole::where('user_id', $user->id)
            ->pluck('role_id');

        $role = Role::where('id', $user_role_id)
            ->pluck('Title');

        // If the role was of an admin, then return all of the timetables

        if ($role[0] == "Admin") {
            $timetables = Timetable::all();
            $users = User::all();
            return view('admin.timetables.index', compact('timetables', 'users'));
        }

        // If the role was of a teacher, only return the timetables that he's concerned of

        if ($role[0] == "Teacher") {

            $timetablesIds = DB::table('teacher_timetables')
                ->where('teacher_id', $user->id)
                ->pluck('timetable_id')
                ->toArray();

            $timetables = Timetable::whereIn('id', $timetablesIds)->get();
            // dd($timetables);
            return view('admin.timetables.index', compact('timetables'));
        }

    }

    
    public function create()
    {
        $sections = Section::all();

        $user = Auth::user();

        return view('admin.timetables.create', compact('sections', 'user'));
    }
    public function edit(Timetable $timetable)
    {
        $sections = Section::all();
        $user = Auth::user();

        return view('admin.timetables.edit', compact('timetable', 'sections', 'user'));
    }

    public function store(Request $request)
    {
        $timetable = Timetable::create($request->only(['admin_id', 'section_id', 'nbr_weeks']));

        return redirect()->route('admin.timetables.index');
    }

    public function update(Request $request, Timetable $timetable)
    {
        $timetable->update($request->only(['admin_id', 'section_id']));

        return redirect()->route('admin.timetables.index');
    }

    public function destroy(Timetable $timetable)
    {

        $timetable->delete();

        return back();
    }
}