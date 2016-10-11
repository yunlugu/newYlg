<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('account_id')->unsigned()->index();
			$table->timestamps();
			$table->softDeletes();
			$table->string('full_name', 20)->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('phone')->nullable();
			$table->string('email');
			$table->string('password');
			$table->string('confirmation_code');
			$table->boolean('is_registered')->default(0);
			$table->boolean('is_confirmed')->default(0);
			$table->boolean('is_parent')->default(0);
			$table->string('remember_token', 100)->nullable();
			$table->string('api_token', 60)->nullable()->unique();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
