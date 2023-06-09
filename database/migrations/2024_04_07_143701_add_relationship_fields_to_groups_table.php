<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id', 'section_fk_1001643')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            //
        });
    }
}
