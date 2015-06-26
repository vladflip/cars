<?php namespace App\Http\Controllers;

class CatalogController extends Controller {

	public function index() {

		$makes = \App\Make::has('companies')
		->orderBy('soviet', 'DESC')
		->orderBy('title', 'ASC')
		->get();

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

		$c = \App\Company::whereHas('makes', function($q) use($make){
			$q->where('make_id', '=', $make->id);
		})
		->whereHas('spec', function($q) use($spec)	{
			$q->where('spec_id', $spec->id);
		})
		->take(6)
		->get();

		$companies = array();

		foreach($c as $key => $val){

			$arr = array();

			$t = array();

			$arr['name'] = $val->name;
			$arr['description'] = $val->description;
			$arr['phone'] = $val->phone;
			$arr['logo'] = $val->logo;
			$arr['address'] = $val->address;

			$t[] = $val->spec->title;
			$t[] = $val->type->title;

			foreach($val->makes as $k => $v){

				$t[] = $v->title;

			}

			$arr['tags'] = $t;

			$companies[] = $arr;

		}

		$bread = ['spec' => $spec, 'make' => $make];

		return view('pages.make-catalog')
			->with('current', $spec->name)
			->with('spec_id', $spec->id)
			->with('make_id', $make->id)
			->with('bread', $bread)
			->with('companies', $companies);

	}

	public function allmakes($make) {

		$make = \App\Make::whereName($make)->first();

		if(!$make)
			abort(404);

		$c = \App\Company::whereHas('makes', function($q) use($make){
			$q->where('make_id', '=', $make->id);
		})
		->take(6)
		->get();

		$companies = array();

		foreach($c as $key => $val){

			$arr = array();

			$t = array();

			$arr['name'] = $val->name;
			$arr['description'] = $val->description;
			$arr['phone'] = $val->phone;
			$arr['logo'] = $val->logo;
			$arr['address'] = $val->address;

			$t[] = $val->spec->title;
			$t[] = $val->type->title;

			foreach($val->makes as $k => $v){

				$t[] = $v->title;

			}

			$arr['tags'] = $t;

			$companies[] = $arr;

		}

		$bread = ['allmakes' => $make];

		return view('pages.make-catalog')
			->with('bread', $bread)
			->with('make_id', $make->id)
			->with('allmakes', true)
			->with('companies', $companies);

	}

}