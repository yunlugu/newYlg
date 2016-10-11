<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuestionTicketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('question_ticket', function(Blueprint $table)
		{
			$table->foreign('question_id')->references('id')->on('questions')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('ticket_id')->references('id')->on('tickets')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('question_ticket', function(Blueprint $table)
		{
			$table->dropForeign('question_ticket_question_id_foreign');
			$table->dropForeign('question_ticket_ticket_id_foreign');
		});
	}

}
