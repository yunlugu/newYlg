<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAttendeesBakTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('attendees_bak', function(Blueprint $table)
		{
			$table->foreign('account_id', 'attendees_account_id_foreign')->references('id')->on('accounts')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('event_id', 'attendees_event_id_foreign')->references('id')->on('events')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('order_id', 'attendees_order_id_foreign')->references('id')->on('orders')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('ticket_id', 'attendees_ticket_id_foreign')->references('id')->on('tickets')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('attendees_bak', function(Blueprint $table)
		{
			$table->dropForeign('attendees_account_id_foreign');
			$table->dropForeign('attendees_event_id_foreign');
			$table->dropForeign('attendees_order_id_foreign');
			$table->dropForeign('attendees_ticket_id_foreign');
		});
	}

}
