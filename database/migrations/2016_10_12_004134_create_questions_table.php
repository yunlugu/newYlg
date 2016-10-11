<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->integer('question_type_id')->unsigned()->index('questions_question_type_id_foreign');
			$table->integer('account_id')->unsigned()->index();
			$table->boolean('is_required')->default(0);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('sort_order')->default(1);
			$table->boolean('is_enabled')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('questions');
	}

}
