<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherTimetable extends Model
{
    use HasFactory;
    protected $fillable = [
        'timetable_id',
        'teacher_id',
    ];
}
