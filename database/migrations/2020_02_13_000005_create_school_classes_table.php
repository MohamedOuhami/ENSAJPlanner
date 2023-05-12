<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolClassesTable extends Migration
{
    public function up()
    {
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->integer('volume_horaire_Cours');
            $table->integer('volume_horaire_TD');
            $table->integer('volume_horaire_TP');
            $table->integer('occ_per_week_Cours');
            $table->integer('occ_per_week_TD');
            $table->integer('occ_per_week_TP');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    
}
