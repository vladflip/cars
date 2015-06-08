<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackPlusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feedback_pluses', function(Blueprint $t)
		{
			
			$t->integer('feedback_id')->unsigned();
			$t->integer('plus_id')->unsigned();

			$t->primary(['feedback_id', 'plus_id']);

			$t->foreign('feedback_id')->references('id')->on('feedback')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('plus_id')->references('id')->on('pluses')
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
		Schema::drop('feedback_pluses');
	}

}
