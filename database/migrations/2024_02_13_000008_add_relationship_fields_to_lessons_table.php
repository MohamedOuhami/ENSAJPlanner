<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLessonsTable extends Migration
{
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->unsignedInteger('teacher_id')->nullable();
            $table->foreign('teacher_id', 'teacher_fk_1001496')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('timetable_id');
            $table->foreign('timetable_id', 'timetable_fk_1001456')->references('id')->on('timetables')->onDelete('cascade');
            $table->unsignedBigInteger('code_matiere');
            $table->foreign('code_matiere', 'matiere_fk_100345')->references('id')->on('school_classes')->onDelete('cascade');;
            $table->unsignedBigInteger('salle_id')->nullable();
            $table->foreign('salle_id', 'salle_fk_103984')->references('id')->on('salles')->onDelete('cascade');
            
        });
    }
}
