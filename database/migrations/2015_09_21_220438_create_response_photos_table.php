<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsePhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('response_photos', function(Blueprint $t)
		{
			$t->increments('id');

			$t->integer('response_id')->unsigned();

			$t->string('src');

			$t->foreign('response_id')->references('id')->on('responses')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('response_photos');
	}

}
