<?php namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;
use Auth;

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

			$specs = \App\Singleton::specs();

			// current is only for pages where no specs active, passes false

			$v->with('specs', $specs)->with('current', $current);

		});

		View::composer('inc.footer', function($v) {

			$pages = \App\Page::all();

			$v->with('pages', $pages);

		});

		View::composer('inc.menu', function($v) {

			$pages = \App\Page::whereInHeader(1)->get();

			$path = \Request::path();

			$catalog = 'active';

			$c = strpos($path, 'catalog');

			if($c === false)
				$catalog = '';

			$feedback = 'active';

			$f = strpos($path, 'feedback');

			if($f === false)
				$feedback = '';

			$contacts = 'active';

			$f = strpos($path, 'contacts');

			if($f === false)
				$contacts = '';

			$v->with('catalog', $catalog)
				->with('feedback', $feedback)
				->with('pages', $pages)
				->with('contacts', $contacts);

		});

		View::composer(['inc.search', 'inc.feedback', 'inc.type', 'popups.create-company', 'popups.company-signup'], function($v) {

			$types = \App\Singleton::types();

			$v->with('types', $types);

		});

		View::composer(['inc.parts', 'popups.create-company', 'popups.company-signup'], function($v) {

			$specs = \App\Singleton::specs();

			$v->with('specs', $specs);

		});
	}

	public function register()
	{
		//
	}

}