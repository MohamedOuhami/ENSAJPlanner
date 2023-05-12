<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('section_id')->nullable();
            $table->foreign('section_id', 'section_fk_1001537')->references('id')->on('sections');

            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id', 'group_fk_1001537')->references('id')->on('groups');
        });
    }
}
