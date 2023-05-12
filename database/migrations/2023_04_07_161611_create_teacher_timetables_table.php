<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_timetables', function (Blueprint $table) {
            $table->unsignedInteger('teacher_id');
            $table->foreign('teacher_id', 'admin_fk_1001496')->references('id')->on('users');
            $table->unsignedBigInteger('timetable_id');
            $table->foreign('timetable_id', 'timetable_fk_10453496')->references('id')->on('timetables');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_timetables');
    }
}
