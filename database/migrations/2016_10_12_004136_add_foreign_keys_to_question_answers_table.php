<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuestionAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('question_answers', function(Blueprint $table)
		{
			$table->foreign('account_id')->references('id')->on('accounts')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('attendee_id')->references('id')->on('attendees_bak')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('event_id')->references('id')->on('events')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('question_id')->references('id')->on('questions')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('question_answers', function(Blueprint $table)
		{
			$table->dropForeign('question_answers_account_id_foreign');
			$table->dropForeign('question_answers_attendee_id_foreign');
			$table->dropForeign('question_answers_event_id_foreign');
			$table->dropForeign('question_answers_question_id_foreign');
		});
	}

}
