<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeMakesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('type_makes', function(Blueprint $t)
		{

			$t->integer('type_id')->unsigned();
			$t->integer('make_id')->unsigned();

			$t->primary(['type_id', 'make_id']);

			$t->foreign('type_id')->references('id')->on('types')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('make_id')->references('id')->on('makes')
											->onDelete('cascade')
											->onUpdate('no action');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('type_makes');
	}

}
