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

			$data = $v->getData();

			if(isset($data['current']))
				$current = $data['current'];
			else
				$current = false;

			$specs = \App\Spec::select('name', 'title')->get();

			// current is only for pages where no specs active, passes false

			$v->with('specs', $specs)->with('current', $current);

		});

		View::composer('inc.menu', function($v) {

			$path = \Request::path();

			$catalog = 'active';

			$c = strpos($path, 'catalog');

			if($c === false)
				$catalog = '';

			$feedback = 'active';

			$f = strpos($path, 'feedback');

			if($f === false)
				$feedback = '';

			$v->with('catalog', $catalog)
				->with('feedback', $feedback);

		});

		View::composer('inc.search', function($v) {

			$types = \App\Type::select('id', 'title')->get();

			$v->with('types', $types);

			$makes = \App\Make::select('id', 'title')->get();

			$v->with('makes', $makes);

			$models = \App\CarModel::select('id', 'title')->get();

			$v->with('models', $models);

		});
	}

	public function register()
	{
		//
	}

}