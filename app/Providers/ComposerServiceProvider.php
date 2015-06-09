<?php namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

	/**
	 * Register bindings in the container.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Using class based composers...
		// View::composer('specs', 'App\Http\ViewComposers\SpecsComposer');

		View::composer('inc.specs', function($v) {

			$specs = \App\Spec::all();

			$v->with('specs', $specs);

		});
	}

	public function register()
	{
		//
	}

}