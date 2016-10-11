<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('edited_by_user_id')->unsigned()->nullable()->index('tickets_edited_by_user_id_foreign');
			$table->integer('account_id')->unsigned()->index();
			$table->integer('order_id')->unsigned()->nullable()->index('tickets_order_id_foreign');
			$table->integer('event_id')->unsigned()->index();
			$table->string('title');
			$table->text('description', 65535);
			$table->decimal('price', 13);
			$table->integer('max_per_person')->nullable();
			$table->integer('min_per_person')->nullable();
			$table->integer('quantity_available')->nullable();
			$table->integer('quantity_sold')->default(0);
			$table->dateTime('start_sale_date')->nullable();
			$table->dateTime('end_sale_date')->nullable();
			$table->decimal('sales_volume', 13)->default(0.00);
			$table->decimal('organiser_fees_volume', 13)->default(0.00);
			$table->boolean('is_paused')->default(0);
			$table->integer('public_id')->unsigned()->nullable()->index();
			$table->integer('user_id')->unsigned()->index('tickets_user_id_foreign');
			$table->integer('sort_order')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tickets');
	}

}
