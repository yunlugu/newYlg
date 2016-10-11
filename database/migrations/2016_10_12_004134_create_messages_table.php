<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('message', 65535);
			$table->string('subject');
			$table->string('recipients')->nullable();
			$table->integer('account_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index('messages_user_id_foreign');
			$table->integer('event_id')->unsigned()->index('messages_event_id_foreign');
			$table->integer('is_sent')->unsigned()->default(0);
			$table->dateTime('sent_at')->nullable();
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
		Schema::drop('messages');
	}

}
