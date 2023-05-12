<?php

namespace App;

use App\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Section extends Model
{
    use HasFactory;

    public $table = 'sections';

    public $timestamps = false;
    protected $fillable = [
        'intitule',
        'Semester',
    ];

    // Defining the one to Many ( Inverse ) relationship between Group and Section
    public function groups(): HasMany{
        return $this->hasMany(Group::class);
    }

    public function timetable(): HasOne{
        return $this->hasOne(Timetable::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
