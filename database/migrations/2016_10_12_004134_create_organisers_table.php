<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganisersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organisers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('account_id')->unsigned()->index();
			$table->string('name');
			$table->text('about', 65535);
			$table->string('email');
			$table->string('phone')->nullable();
			$table->string('confirmation_key', 20);
			$table->string('facebook');
			$table->string('twitter');
			$table->string('logo_path')->nullable();
			$table->boolean('is_email_confirmed')->default(0);
			$table->boolean('show_twitter_widget')->default(0);
			$table->boolean('show_facebook_widget')->default(0);
			$table->string('page_header_bg_color', 20)->default('#76a867');
			$table->string('page_bg_color', 20)->default('#EEEEEE');
			$table->string('page_text_color', 20)->default('#FFFFFF');
			$table->boolean('enable_organiser_page')->default(1);
			$table->string('google_analytics_code')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('organisers');
	}

}
