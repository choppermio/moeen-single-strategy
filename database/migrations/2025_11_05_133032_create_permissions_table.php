<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., 'view_tasks', 'manage_tickets'
            $table->string('display_name'); // e.g., 'عرض المهام', 'إدارة التذاكر'
            $table->string('description')->nullable();
            $table->string('route')->nullable(); // Associated route
            $table->string('group')->default('general'); // Group permissions (tasks, tickets, strategy, etc.)
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
        Schema::dropIfExists('permissions');
    }
}
