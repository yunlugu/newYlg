<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_images', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('image_path');
			$table->timestamps();
			$table->integer('event_id')->unsigned()->index('event_images_event_id_foreign');
			$table->integer('account_id')->unsigned()->index('event_images_account_id_foreign');
			$table->integer('user_id')->unsigned()->index('event_images_user_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('event_images');
	}

}
