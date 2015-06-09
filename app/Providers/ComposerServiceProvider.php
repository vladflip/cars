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
		View::composer('specs', 'App\Http\ViewComposers\SpecsComposer');

		View::composer('inc.specs', function($v) {

			$data = $v->getData();

			if(isset($data['current']))
				$current = $data['current'];
			else
				$current = false;

			$specs = \App\Spec::select('name', 'title')->get();

			// current is only for pages where no specs active

			$v->with('specs', $specs)->with('current', $current);

		});

		View::composer('inc.menu', function($v) {

			$path = \Request::path();

			$catalog = 'active';

			$pos = strpos($path, 'catalog');

			if($pos === false)
				$catalog = '';

			$v->with('catalog', $catalog);

		});
	}

	public function register()
	{
		//
	}

}