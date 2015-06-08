<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackLikesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feedback_likes', function(Blueprint $t)
		{
			
			$t->integer('feedback_id')->unsigned();
			$t->integer('user_id')->unsigned();

			$t->primary(['feedback_id', 'user_id']);

			$t->foreign('feedback_id')->references('id')->on('feedback')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('user_id')->references('id')->on('users')
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
		Schema::drop('feedback_likes');
	}

}
