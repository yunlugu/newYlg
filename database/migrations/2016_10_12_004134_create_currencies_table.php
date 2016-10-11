<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currencies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('symbol_left', 12);
			$table->string('symbol_right', 12);
			$table->string('code', 3);
			$table->integer('decimal_place');
			$table->float('value', 15, 8);
			$table->string('decimal_point', 3);
			$table->string('thousand_point', 3);
			$table->integer('status');
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
		Schema::drop('currencies');
	}

}
