<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class TimetableOptimizerController extends Controller
{

    public function index(){
        return view('admin.timetableoptimizer.index');
    }
    public function create($seconds)
    {
        $my_seconds = $seconds;
        // Optimize the timetables
        
        $process = new Process(['python3', app_path().'/optimizer/main.py',$my_seconds]);
        $process->setTimeout(3600);
        // dd($process);
        $process->run();


        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $score = $process->getOutput();

        return view('admin.timetableoptimizer.index',compact('score'));
    }
}
