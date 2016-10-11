<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('accounts', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('date_format_id')->references('id')->on('date_formats')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('datetime_format_id')->references('id')->on('date_formats')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('payment_gateway_id')->references('id')->on('payment_gateways')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('timezone_id')->references('id')->on('timezones')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('accounts', function(Blueprint $table)
		{
			$table->dropForeign('accounts_currency_id_foreign');
			$table->dropForeign('accounts_date_format_id_foreign');
			$table->dropForeign('accounts_datetime_format_id_foreign');
			$table->dropForeign('accounts_payment_gateway_id_foreign');
			$table->dropForeign('accounts_timezone_id_foreign');
		});
	}

}
