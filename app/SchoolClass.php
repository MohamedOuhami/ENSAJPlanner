<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SchoolClass extends Model
{
    use SoftDeletes;

    public $table = 'school_classes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'volume_horaire_Cours',
        'volume_horaire_TD',
        'volume_horaire_TP',
        'occ_per_week_Cours',
        'occ_per_week_TD',
        'occ_per_week_TP',
        'code_module',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class,'code_module');
    }
}
