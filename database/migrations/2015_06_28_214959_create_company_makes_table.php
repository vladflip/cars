<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyMakesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_makes', function(Blueprint $t)
		{

			$t->integer('company_id')->unsigned();
			$t->integer('make_id')->unsigned();

			$t->primary(['company_id', 'make_id']);

			$t->foreign('company_id')->references('id')->on('companies')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('make_id')->references('id')->on('makes')
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
		Schema::drop('company_makes');
	}

}
