<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attendees', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('event_id')->unsigned()->index();
			$table->integer('member_id')->index('member_id');
			$table->string('full_name', 10)->nullable();
			$table->string('email');
			$table->integer('private_reference_number')->index();
			$table->timestamps();
			$table->softDeletes();
			$table->boolean('is_cancelled')->default(0);
			$table->boolean('has_arrived')->default(0);
			$table->dateTime('arrival_time')->nullable();
			$table->integer('reference_index')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attendees');
	}

}
