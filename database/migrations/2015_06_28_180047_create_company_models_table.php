<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyModelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_models', function(Blueprint $t)
		{

			$t->integer('company_id')->unsigned();
			$t->integer('model_id')->unsigned();

			$t->primary(['company_id', 'model_id']);

			$t->foreign('company_id')->references('id')->on('companies')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('model_id')->references('id')->on('models')
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
		Schema::drop('company_models');
	}

}
