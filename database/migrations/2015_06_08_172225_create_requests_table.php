<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requests', function(Blueprint $t)
		{
			$t->increments('id');

			$t->integer('user_id')->unsigned();
			$t->integer('type_id')->unsigned();
			$t->integer('make_id')->unsigned();
			$t->integer('model_id')->unsigned();

			$t->tinyInteger('opened');
			$t->tinyInteger('new');
			$t->tinyInteger('old');
			$t->tinyInteger('canceled_by_user')->default(0);
			$t->tinyInteger('status')->default(0);

			$t->string('year');
			$t->text('text');

			$t->foreign('type_id')->references('id')->on('types')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('make_id')->references('id')->on('makes')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('model_id')->references('id')->on('models')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('user_id')->references('id')->on('users')
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
		Schema::drop('requests');
	}

}
