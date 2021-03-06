<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCallsignHandlersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('callsign_handlers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('aircraft_callsign', 244);
			$table->string('departure_airport', 244);
			$table->string('name',244);
			$table->text('email', 65535);
			$table->text('mobile_number',244);
			$table->boolean('is_active');
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
		Schema::drop('callsign_handlers');
	}

}
