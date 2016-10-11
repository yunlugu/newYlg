<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('account_id')->unsigned()->index();
			$table->integer('order_status_id')->unsigned()->index('orders_order_status_id_foreign');
			$table->timestamps();
			$table->softDeletes();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->string('ticket_pdf_path', 155)->nullable();
			$table->string('order_reference', 15);
			$table->string('transaction_id', 50)->nullable();
			$table->decimal('discount')->nullable();
			$table->decimal('booking_fee')->nullable();
			$table->decimal('organiser_booking_fee')->nullable();
			$table->date('order_date')->nullable();
			$table->text('notes', 65535)->nullable();
			$table->boolean('is_deleted')->default(0);
			$table->boolean('is_cancelled')->default(0);
			$table->boolean('is_partially_refunded')->default(0);
			$table->boolean('is_refunded')->default(0);
			$table->decimal('amount', 13);
			$table->decimal('amount_refunded', 13)->nullable();
			$table->integer('event_id')->unsigned()->index();
			$table->integer('payment_gateway_id')->unsigned()->nullable()->index('orders_payment_gateway_id_foreign');
			$table->boolean('is_payment_received')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
