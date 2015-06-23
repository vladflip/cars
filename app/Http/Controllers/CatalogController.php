<?php namespace App\Http\Controllers;

class CatalogController extends Controller {

	public function index() {

		$makes = \App\Make::all();

		return view('pages.catalog')
			->with('makes', $makes)
			->with('allmakes', true)
			->with('bread', false);

	}

	public function specs($name) {

		$spec = \App\Spec::whereName($name)->select('id', 'name', 'title')->first();

		if(!$spec) {
			abort(404);
		}

		$bread = ['spec' => $spec];
		// get makes by name of spec

		$makes = \App\Make::whereHas('companies', function($q) use ($spec){

			$q->where('spec_id', '=', $spec->id);

		})->get();


		return view('pages.catalog')
			->with('current', $name)
			->with('current_id', $spec->id)
			->with('makes', $makes)
			->with('bread', $bread);

	}

	public function companies($spec, $make) {

		$spec = \App\Spec::whereName($spec)->first();

		if(!$spec)
			abort(404);

		$make = \App\Make::whereName($make)->first();

		if(!$make)
			abort(404);

		$bread = ['spec' => $spec, 'make' => $make];

		return view('pages.make-catalog')
			->with('current', $spec->name)
			->with('bread', $bread);

	}

	public function allmakes($make) {

		$make = \App\Make::whereName($make)->first();

		if(!$make)
			abort(404);

		$bread = ['allmakes' => $make];

		return view('pages.make-catalog')
			->with('bread', $bread)
			->with('allmakes', true);

	}

}