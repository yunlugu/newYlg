<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTicketOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ticket_order', function(Blueprint $table)
		{
			$table->foreign('order_id')->references('id')->on('orders')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('ticket_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ticket_order', function(Blueprint $table)
		{
			$table->dropForeign('ticket_order_order_id_foreign');
			$table->dropForeign('ticket_order_ticket_id_foreign');
		});
	}

}
