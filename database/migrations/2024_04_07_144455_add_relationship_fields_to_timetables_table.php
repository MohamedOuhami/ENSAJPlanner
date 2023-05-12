<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->unsignedInteger('admin_id');
            $table->foreign('admin_id', 'admin_fk_10056496')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('section_id')->nullable();
            $table->foreign('section_id', 'section_fk_100252537')->references('id')->on('sections')->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timetables', function (Blueprint $table) {
            //
        });
    }
}
