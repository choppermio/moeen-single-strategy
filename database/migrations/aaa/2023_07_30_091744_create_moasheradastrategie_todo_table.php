<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoasheradastrategieTodoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moasheradastrategie_todo', function (Blueprint $table) {
            $table->id();
            $table->integer('todo_id')->unsigned();
            $table->integer('moasheradastrategie_id')->unsigned();
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
        Schema::dropIfExists('moasheradastrategie_todo');
    }
}
