<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackMinusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feedback_minuses', function(Blueprint $t)
		{
			
			$t->integer('feedback_id')->unsigned();
			$t->integer('minus_id')->unsigned();

			$t->primary(['feedback_id', 'minus_id']);

			$t->foreign('feedback_id')->references('id')->on('feedback')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('minus_id')->references('id')->on('minuses')
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
		Schema::drop('feedback_minuses');
	}

}
