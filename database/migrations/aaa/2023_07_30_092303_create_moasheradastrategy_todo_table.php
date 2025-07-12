<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoasheradastrategyTodoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moasheradastrategy_todo', function (Blueprint $table) {
            $table->id();
            $table->integer('todo_id')->unsigned();
            $table->integer('moasheradastrategy_id')->unsigned();
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
        Schema::dropIfExists('moasheradastrategy_todo');
    }
}
