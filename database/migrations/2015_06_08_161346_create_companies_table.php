<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $t)
		{
			$t->increments('id');

			$t->integer('user_id')->unsigned();
			$t->integer('spec_id')->unsigned();
			$t->integer('type_id')->unsigned();

			$t->string('name');
			$t->string('phone', 45);
			$t->string('logo');
			$t->string('address');
			$t->text('about');


			$t->foreign('user_id')->references('id')->on('users')
											->onDelete('cascade')
											->onUpdate('no action');

			$t->foreign('spec_id')->references('id')->on('specs')
											->onDelete('no action')
											->onUpdate('no action');

			$t->foreign('type_id')->references('id')->on('types')
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
		Schema::drop('companies');
	}

}
