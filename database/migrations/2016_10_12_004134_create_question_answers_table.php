<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_answers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('attendee_id')->unsigned()->index();
			$table->integer('event_id')->unsigned()->index();
			$table->integer('question_id')->unsigned()->index();
			$table->integer('account_id')->unsigned()->index();
			$table->text('answer_text', 65535);
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
		Schema::drop('question_answers');
	}

}
