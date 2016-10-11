<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountPaymentGatewaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_payment_gateways', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('account_id')->unsigned()->index('account_payment_gateways_account_id_foreign');
			$table->integer('payment_gateway_id')->unsigned()->index('account_payment_gateways_payment_gateway_id_foreign');
			$table->text('config', 65535);
			$table->softDeletes();
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
		Schema::drop('account_payment_gateways');
	}

}
