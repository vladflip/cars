<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('responses', function(Blueprint $t)
		{
			$t->increments('id');

			$t->integer('request_id')->unsigned();
			$t->integer('company_id')->unsigned();

			$t->text('text');

			$t->foreign('request_id')->references('id')->on('requests')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('company_id')->references('id')->on('companies')
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
		Schema::drop('responses');
	}

}
