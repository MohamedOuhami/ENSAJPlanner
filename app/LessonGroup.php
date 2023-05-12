<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonGroup extends Model
{
    use HasFactory;
    public $table = 'lesson_group';

    protected $fillable = [
        'lesson_id',
        'group_id'
    ];
}
