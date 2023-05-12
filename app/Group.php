<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    public $table = 'groups';


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'intitule',
        'section_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function users(){
        return $this->hasMany(User::class);
    }
    // Defining the one to many relationship between Group and Section
    public function section()
    {
        return $this->belongsTo(Section::class,'section_id');
    }

    // Defining the many to many relationship between Group and Lesson
    public function lessons(){
        return $this->belongsToMany(Lesson::class);
    }

}