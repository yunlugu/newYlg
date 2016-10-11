<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->foreign('account_id')->references('id')->on('accounts')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('event_id')->references('id')->on('events')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('order_status_id')->references('id')->on('order_statuses')->onUpdate('RESTRICT')->onDelete('NO ACTION');
			$table->foreign('payment_gateway_id')->references('id')->on('payment_gateways')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->dropForeign('orders_account_id_foreign');
			$table->dropForeign('orders_event_id_foreign');
			$table->dropForeign('orders_order_status_id_foreign');
			$table->dropForeign('orders_payment_gateway_id_foreign');
		});
	}

}
