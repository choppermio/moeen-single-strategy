<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompleteToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            
            $table->decimal('marketing_cost', 8, 2);
            $table->decimal('real_cost', 8, 2);
            $table->date('sp_week')->nullable();
            $table->date('ep_week')->nullable();
            $table->date('sr_week')->nullable();
            $table->date('er_week')->nullable();
            $table->decimal('r_money_paid', 8, 2);
            $table->boolean('marketing_verified');
            $table->unsignedTinyInteger('complete_percentage');
            $table->unsignedTinyInteger('quality_percentage');
            $table->text('evidence')->nullable();
            $table->decimal('roi', 8, 2);
            $table->integer('customers_count');
            $table->text('perf_note')->nullable();
            $table->boolean('recomm');
            $table->text('notes')->nullable();
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
            //
        });
    }
}
