<?php

namespace App\Http\Controllers\Admin;

use App\Salle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Facade\FlareClient\Http\Response;

class SalleController extends Controller
{
    public function index()
    {

        $salles = Salle::all();

        return view('admin.salles.index', compact('salles'));
    }
    public function update(Request $request, Salle $salle)
    {
        $salle->update($request->all());

        return redirect()->route('admin.salles.index');
    }

    public function create()
    {
        $salles = Salle::all();

        return view('admin.salles.create',compact('salles'));
    }

    public function edit(Salle $salle)
    {

        return view('admin.salles.edit', compact('salle'));
    }

    public function store(Request $request)
    {
        $salle = Salle::create($request->all());

        return redirect()->route('admin.salles.index');
    }

    public function destroy(Salle $salle)
    {

        $salle->delete();

        return back();
    }
}
