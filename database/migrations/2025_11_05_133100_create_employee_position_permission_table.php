<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePositionPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_position_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_position_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();

            $table->foreign('employee_position_id', 'emp_pos_perm_emp_pos_fk')
                ->references('id')->on('employee_positions')->onDelete('cascade');
            $table->foreign('permission_id', 'emp_pos_perm_perm_fk')
                ->references('id')->on('permissions')->onDelete('cascade');
            
            $table->unique(['employee_position_id', 'permission_id'], 'emp_pos_perm_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_position_permission');
    }
}
