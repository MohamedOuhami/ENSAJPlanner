<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    public $table = 'modules';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'intitule',
        'Semester',
        'volume_horaire',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Defining the One to Many relationship between Matiere and Module
    public function Matieres(){
        return $this->hasMany(SchoolClass::class);
    }
}
