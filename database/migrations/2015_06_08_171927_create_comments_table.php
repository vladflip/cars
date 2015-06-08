<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $t)
		{
			$t->increments('id');

			$t->integer('user_id')->unsigned();
			$t->integer('feedback_id')->unsigned();

			$t->integer('parent_id')->unsigned();

			$t->text('text');

			$t->foreign('user_id')->references('id')->on('users')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('feedback_id')->references('id')->on('feedback')
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
		Schema::drop('comments');
	}

}
