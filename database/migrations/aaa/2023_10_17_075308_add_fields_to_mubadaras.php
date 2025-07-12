<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToMubadaras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mubadaras', function (Blueprint $table) {
            $table->text('general_desc')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->decimal('estimate_cost', 8, 2)->nullable(); // Adjust precision and scale as needed
            $table->text('dangers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mubadaras', function (Blueprint $table) {
            $table->dropColumn('general_desc');
            $table->dropColumn('date_from');
            $table->dropColumn('date_to');
            $table->dropColumn('estimate_cost');
            $table->dropColumn('dangers');
        });
    }
}
