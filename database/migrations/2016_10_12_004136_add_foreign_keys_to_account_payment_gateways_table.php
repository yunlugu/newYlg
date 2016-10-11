<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAccountPaymentGatewaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('account_payment_gateways', function(Blueprint $table)
		{
			$table->foreign('account_id')->references('id')->on('accounts')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('payment_gateway_id')->references('id')->on('payment_gateways')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('account_payment_gateways', function(Blueprint $table)
		{
			$table->dropForeign('account_payment_gateways_account_id_foreign');
			$table->dropForeign('account_payment_gateways_payment_gateway_id_foreign');
		});
	}

}
