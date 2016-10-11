<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReservedTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reserved_tickets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('ticket_id');
			$table->integer('event_id');
			$table->integer('quantity_reserved');
			$table->dateTime('expires');
			$table->string('session_id', 45);
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
		Schema::drop('reserved_tickets');
	}

}
