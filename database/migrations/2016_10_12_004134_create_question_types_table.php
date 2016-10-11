<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('alias');
			$table->string('name');
			$table->boolean('has_options')->default(0);
			$table->boolean('allow_multiple')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('question_types');
	}

}
