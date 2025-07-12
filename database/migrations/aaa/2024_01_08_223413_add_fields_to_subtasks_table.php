<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSubtasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subtasks', function (Blueprint $table) {
            $table->boolean('transfered')->default(false); // oh look, a boolean. hope that's not too advanced for you.
            $table->unsignedBigInteger('parent_user_id')->nullable(); // foreign keys should be unsigned. you're welcome.
            $table->unsignedBigInteger('finished_user_id')->nullable(); // another one, just to make sure you're paying attention.
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subtasks', function (Blueprint $table) {
            //
        });
    }
}
