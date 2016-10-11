<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('account_id')->unsigned()->index('users_account_id_index');
			$table->integer('organiser_id')->nullable()->index('organiser_id');
			$table->integer('department_id')->nullable()->index('department_id');
			$table->integer('group_id')->nullable()->index('group_id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('full_name', 20)->nullable();
			$table->string('sex', 5)->nullable();
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
			$table->string('api_token', 60)->nullable()->unique('users_api_token_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('members');
	}

}
