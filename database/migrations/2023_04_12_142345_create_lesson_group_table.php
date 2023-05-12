<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_group', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id', 'group_fk_1056537')->references('id')->on('groups')->onDelete('cascade');

            $table->unsignedBigInteger('lesson_id');
            $table->foreign('lesson_id', 'lesson_fk_1009837')->references('id')->on('lessons')->onDelete('cascade');
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
        Schema::dropIfExists('lesson_group');
    }
}
