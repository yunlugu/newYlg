<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventStatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_stats', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('date');
			$table->integer('views')->default(0);
			$table->integer('unique_views')->default(0);
			$table->integer('tickets_sold')->default(0);
			$table->decimal('sales_volume', 13)->default(0.00);
			$table->decimal('organiser_fees_volume', 13)->default(0.00);
			$table->integer('event_id')->unsigned()->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('event_stats');
	}

}
