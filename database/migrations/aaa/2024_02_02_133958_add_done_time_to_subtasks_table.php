<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDoneTimeToSubtasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subtasks', function (Blueprint $table) {
            $table->dateTime('due_time')->nullable();
            $table->dateTime('done_time')->nullable();

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
