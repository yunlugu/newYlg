<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendeesBakTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attendees_bak', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->unsigned()->index('attendees_order_id_index');
			$table->integer('event_id')->unsigned()->index('attendees_event_id_index');
			$table->integer('ticket_id')->unsigned()->index('attendees_ticket_id_index');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->integer('private_reference_number')->index('attendees_private_reference_number_index');
			$table->timestamps();
			$table->softDeletes();
			$table->boolean('is_cancelled')->default(0);
			$table->boolean('has_arrived')->default(0);
			$table->dateTime('arrival_time')->nullable();
			$table->integer('account_id')->unsigned()->index('attendees_account_id_index');
			$table->integer('reference_index')->default(0);
			$table->boolean('is_refunded')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attendees_bak');
	}

}
