<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->string('full_name', 20)->nullable();
			$table->integer('timezone_id')->unsigned()->nullable()->index('accounts_timezone_id_foreign');
			$table->integer('date_format_id')->unsigned()->nullable()->index('accounts_date_format_id_foreign');
			$table->integer('datetime_format_id')->unsigned()->nullable()->index('accounts_datetime_format_id_foreign');
			$table->integer('currency_id')->unsigned()->nullable()->index('accounts_currency_id_foreign');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name')->nullable();
			$table->string('last_ip')->nullable();
			$table->dateTime('last_login_date')->nullable();
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('postal_code')->nullable();
			$table->integer('country_id')->unsigned()->nullable();
			$table->text('email_footer', 65535)->nullable();
			$table->boolean('is_active')->default(0);
			$table->boolean('is_banned')->default(0);
			$table->boolean('is_beta')->default(0);
			$table->string('stripe_access_token', 55)->nullable();
			$table->string('stripe_refresh_token', 55)->nullable();
			$table->string('stripe_secret_key', 55)->nullable();
			$table->string('stripe_publishable_key', 55)->nullable();
			$table->text('stripe_data_raw', 65535)->nullable();
			$table->integer('payment_gateway_id')->unsigned()->default(1)->index('accounts_payment_gateway_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('accounts');
	}

}
