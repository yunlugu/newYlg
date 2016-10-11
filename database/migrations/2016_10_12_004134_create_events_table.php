<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('speaker', 20)->nullable();
			$table->integer('department_id')->nullable();
			$table->string('tags', 100)->nullable()->default('培训');
			$table->string('location')->nullable();
			$table->string('bg_type', 15)->default('color');
			$table->string('bg_color')->default('#B23333');
			$table->string('bg_image_path')->nullable();
			$table->text('description', 65535);
			$table->dateTime('start_date')->nullable();
			$table->dateTime('end_date')->nullable();
			$table->dateTime('on_sale_date')->nullable();
			$table->integer('account_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index('events_user_id_foreign');
			$table->integer('currency_id')->unsigned()->nullable()->index('events_currency_id_foreign');
			$table->decimal('sales_volume', 13)->default(0.00);
			$table->decimal('organiser_fees_volume', 13)->default(0.00);
			$table->decimal('organiser_fee_fixed', 13)->default(0.00);
			$table->decimal('organiser_fee_percentage', 4, 3)->default(0.000);
			$table->integer('organiser_id')->unsigned()->index('events_organiser_id_foreign');
			$table->string('venue_name');
			$table->string('venue_name_full')->nullable();
			$table->string('location_address', 355)->nullable();
			$table->string('location_address_line_1', 355);
			$table->string('location_address_line_2', 355);
			$table->string('location_country')->nullable();
			$table->string('location_country_code')->nullable();
			$table->string('location_state');
			$table->string('location_post_code');
			$table->string('location_street_number')->nullable();
			$table->string('location_lat')->nullable();
			$table->string('location_long')->nullable();
			$table->string('location_google_place_id')->nullable();
			$table->text('pre_order_display_message', 65535)->nullable();
			$table->text('post_order_display_message', 65535)->nullable();
			$table->text('social_share_text', 65535)->nullable();
			$table->boolean('social_show_facebook')->default(1);
			$table->boolean('social_show_linkedin')->default(1);
			$table->boolean('social_show_twitter')->default(1);
			$table->boolean('social_show_email')->default(1);
			$table->boolean('social_show_googleplus')->default(1);
			$table->integer('location_is_manual')->unsigned()->default(0);
			$table->boolean('is_live')->default(0);
			$table->timestamps();
			$table->softDeletes();
			$table->string('barcode_type', 20)->default('QRCODE');
			$table->string('ticket_border_color', 20)->default('#000000');
			$table->string('ticket_bg_color', 20)->default('#FFFFFF');
			$table->string('ticket_text_color', 20)->default('#000000');
			$table->string('ticket_sub_text_color', 20)->default('#999999');
			$table->boolean('social_show_whatsapp')->default(1);
			$table->string('questions_collection_type', 10)->default('buyer');
			$table->integer('checkout_timeout_after')->default(8);
			$table->boolean('is_1d_barcode_enabled')->default(0);
			$table->boolean('enable_offline_payments')->default(0);
			$table->text('offline_payment_instructions', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events');
	}

}
