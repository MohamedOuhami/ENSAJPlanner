<?php

namespace App;

use App\User;
use App\Salle;
use App\Matiere;
use App\Group;
use App\Timetable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lesson extends Model
{
    use SoftDeletes;

    public $table = 'lessons';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'weekday',
        'group_id',
        'salle_id',
        'code_matiere',
        'type',
        'end_time',
        'type',
        'timetable_id',
        'teacher_id',
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const WEEK_DAYS = [
        '1' => 'Lundi',
        '2' => 'Mardi',
        '3' => 'Mercredi',
        '4' => 'Jeudi',
        '5' => 'Vendredi',
        '6' => 'Samedi',
        '7' => 'Dimanche',
    ];

    public function getDifferenceAttribute()
    {
        return Carbon::parse($this->end_time)->diffInMinutes($this->start_time);
    }

    public function getStartTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.lesson_time_format')) : null;
    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = $value ? Carbon::createFromFormat(config('panel.lesson_time_format'),
            $value)->format('H:i:s') : null;
    }

    public function getEndTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.lesson_time_format')) : null;
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = $value ? Carbon::createFromFormat(config('panel.lesson_time_format'),
            $value)->format('H:i:s') : null;
    }

    // Define the One to One relatonship between Teacher and Lesson
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Define the One to One relationship between Salle and Lesson
    public function salle()
    {
        return $this->belongsTo(Salle::class,'salle_id');
    }
    // Define the relationship One to One between Matiere and Lesson
    public function matiere()
    {
        return $this->belongsTo(Matiere::class,'code_matiere');
    }
    // Defining the Many to Many relationship between Group and Seance
    public function groupe(){
        return $this->hasMany(Group::class, 'group_id');
    }
    
    // Defining the Many to One Relationship between Lesson and TimeTable
    public function timetable(){
        return $this->belongsTo(Timetable::class,'timetable_id');
    }

    // public static function isTimeAvailable($weekday, $startTime, $endTime, $class, $teacher, $lesson,$group,$salle)
    // {
    //     $lessons = self::where('weekday', $weekday)
    //         ->when($lesson, function ($query) use ($lesson) {
    //             $query->where('id', '!=', $lesson);
    //         })
    //         ->where(function ($query) use ($teacher,$salle) {
    //             $query->Where('teacher_id', $teacher)
    //                 // ->orWhere('group_id',$group)
    //                 ->orWhere('salle_id',$salle);
    //         })
    //         ->where([
    //             ['start_time', '<', $endTime],
    //             ['end_time', '>', $startTime],
    //         ])
    //         ->count();

    //     return !$lessons;
    // }

    // public function scopeCalendarByRoleOrClassId($query)
    // {
    //     return $query->when(!request()->input('class_id'), function ($query) {
    //         $query->when(auth()->user()->is_teacher, function ($query) {
    //             $query->where('teacher_id', auth()->user()->id);
    //         })
    //             ->when(auth()->user()->is_student, function ($query) {
    //                 $query->where('class_id', auth()->user()->class_id ?? '0');
    //             });
    //     })
    //         ->when(request()->input('class_id'), function ($query) {
    //             $query->where('class_id', request()->input('class_id'));
    //         });
    // }
}
