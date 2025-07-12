<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoasheradastrategyMubadaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moasheradastrategy_mubadara', function (Blueprint $table) {
            $table->id();
            $table->integer('moasheradastrategy_id');
            $table->integer('mubadara_id');

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
        Schema::dropIfExists('moasheradastrategy_mubadara');
    }
}
