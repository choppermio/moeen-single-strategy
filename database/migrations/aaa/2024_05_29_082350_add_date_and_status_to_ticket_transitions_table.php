<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateAndStatusToTicketTransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_transitions', function (Blueprint $table) {
            $table->date('date')->after('column_name'); // Adjust 'column_name' to the column after which you want to add the new column
            $table->string('status')->after('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_transitions', function (Blueprint $table) {
            //
        });
    }
}
