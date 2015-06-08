<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('models', function(Blueprint $t)
		{
			$t->increments('id');

			$t->string('name');
			$t->string('icon');
			$t->string('desc');

			$t->integer('make_id')->unsigned();

			$t->foreign('make_id')->references('id')->on('makes')
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
		Schema::drop('models');
	}

}
