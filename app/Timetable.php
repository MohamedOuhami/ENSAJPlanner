<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timetable extends Model
{
    use HasFactory;

    public $table = 'timetables';
    public $timestamps = false;



    protected $fillable = [
        'admin_id',
        'nbr_weeks',
        'section_id',
    ];

    

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

}
