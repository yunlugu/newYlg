<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function ($table) {
            $table->string('venue_name')->nullable()->change();
            $table->string('location_address_line_1')->nullable()->change();
            $table->string('location_address_line_2')->nullable()->change();
            $table->string('location_state')->nullable()->change();
            $table->string('location_post_code')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
