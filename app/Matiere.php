<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    public $table = 'school_classes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'intitule',
        'volume_horaire',
        'occ_per_week',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Defining the one to many relationship between Mateire and Module
    public function module(){
        return $this->belongsTo(Module::class);
    }
}
