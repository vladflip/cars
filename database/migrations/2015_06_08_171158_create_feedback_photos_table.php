<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackPhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feedback_photos', function(Blueprint $t)
		{
			
			$t->integer('feedback_id')->unsigned();
			$t->integer('photo_id')->unsigned();

			$t->primary(['feedback_id', 'user_id']);

			$t->foreign('feedback_id')->references('id')->on('feedback')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('photo_id')->references('id')->on('photos')
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
		Schema::drop('feedback_photos');
	}

}
