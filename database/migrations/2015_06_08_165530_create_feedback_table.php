<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feedback', function(Blueprint $t)
		{
			$t->increments('id');

			$t->integer('type_id')->unsigned();
			$t->integer('make_id')->unsigned();
			$t->integer('model_id')->unsigned();
			$t->integer('user_id')->unsigned();

			$t->integer('likes_count')->unsigned();
			$t->integer('dislikes_count')->unsigned();

			$t->string('header');
			$t->text('content');
			$t->string('logo');

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
		Schema::drop('feedback');
	}

}
