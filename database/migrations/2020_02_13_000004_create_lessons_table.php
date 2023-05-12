<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('weekday')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string("type");
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
