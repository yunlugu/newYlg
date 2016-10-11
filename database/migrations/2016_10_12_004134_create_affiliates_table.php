<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAffiliatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('affiliates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 125);
			$table->integer('visits');
			$table->integer('tickets_sold');
			$table->decimal('sales_volume', 10)->default(0.00);
			$table->timestamp('last_visit')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('account_id')->unsigned()->index();
			$table->integer('event_id')->unsigned()->index('affiliates_event_id_foreign');
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
		Schema::drop('affiliates');
	}

}
