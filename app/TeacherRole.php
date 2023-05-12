<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherRole extends Model
{
    use HasFactory;
    public $table = 'role_user';
    protected $fillable=[
        'user_id',
        'role_id',
    ];
}
