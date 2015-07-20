<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('read_requests', function(Blueprint $t)
		{
			
			$t->integer('request_id')->unsigned();
			$t->integer('company_id')->unsigned();

			$t->primary(['request_id', 'company_id']);

			$t->foreign('request_id')->references('id')->on('requests')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('company_id')->references('id')->on('companies')
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
		Schema::drop('read_requests');
	}

}
