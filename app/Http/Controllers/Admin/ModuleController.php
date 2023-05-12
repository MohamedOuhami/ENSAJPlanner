<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreSchoolClassRequest;
use Symfony\Component\HttpFoundation\Response;

class ModuleController extends Controller
{
    // Setting up the index function

    public function index()
    {
        $modules = Module::all();

        return view('admin.modules.index', compact('modules'));
    }

    // Setting up the create function

    public function create()
    {

        return view('admin.modules.create');
    }

    // Setting up the store function
    public function store(Request $request)
    {
        $module = Module::create($request->all());

        return redirect()->route('admin.modules.index');

    }

    public function edit(Module $module)
    {

        return view('admin.modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $module->update($request->all());

        return redirect()->route('admin.modules.index');
    }

    public function destroy(Module $module)
    {
        abort_if(Gate::denies('school_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $module->delete();

        return back();
    }

 
}
