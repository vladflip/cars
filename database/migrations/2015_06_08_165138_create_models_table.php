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
			$t->string('title');
			
			$t->index('name');

			$t->integer('make_id')->unsigned();

			$t->integer('type_id')->unsigned();

			$t->foreign('make_id')->references('id')->on('makes')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('type_id')->references('id')->on('types')
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
