<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('output')->nullable();
            $table->decimal('cost_market', 8, 2)->nullable(); // Adjust precision and scale as needed
            $table->decimal('cost', 8, 2)->nullable(); // Adjust precision and scale as needed
            $table->integer('user')->nullable();
            $table->date('start_week')->nullable();
            $table->date('end_week')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('output');
            $table->dropColumn('cost_market');
            $table->dropColumn('cost');
            $table->dropColumn('user');
            $table->dropColumn('start_week');
            $table->dropColumn('end_week');
        });
    }
}
