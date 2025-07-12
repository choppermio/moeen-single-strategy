<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskUserAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_user_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->nullable();
            $table->unsignedBigInteger('subtask_id')->nullable();
            $table->unsignedBigInteger('employee_position_id');
            $table->enum('type', ['task', 'subtask'])->default('subtask');
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['task_id', 'employee_position_id']);
            $table->index(['subtask_id', 'employee_position_id']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_user_assignments');
    }
}
