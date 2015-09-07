<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_requests', function(Blueprint $t)
		{

			$t->increments('id');
			
			$t->integer('request_id')->unsigned();
			$t->integer('company_id')->unsigned();

			$t->tinyInteger('read')->default(0);
			$t->tinyInteger('replied')->default(0);
			$t->tinyInteger('canceled_by_company')->default(0);

			$t->timestamp('updated_at');

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
		Schema::drop('company_requests');
	}

}
