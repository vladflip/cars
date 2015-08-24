<?php namespace App\Http\Controllers;

class CatalogController extends Controller {

	public function index() {

		$makes = \App\Make::has('companies')
		->orderBy('soviet', 'DESC')
		->orderBy('title', 'ASC')
		->get();

		return view('pages.catalog.nospecs')
			->with('makes', $makes)
			->with('bread', false);

	}

	public function specs($name) {

		$spec = \App\Spec::whereName($name)->select('id', 'name', 'title')->first();

		if(!$spec) {
			abort(404);
		}

		$bread = ['spec' => $spec];

		$makes = \App\Make::whereHas('companies', function($q) use ($spec){

			$q->where('spec_id', $spec->id);

		})->get();


		return view('pages.catalog.withspecs')
			->with('spec', $spec)
			->with('makes', $makes)
			->with('bread', $bread);

	}

	public function withspecs($spec, $make) {

		$spec = \App\Spec::whereName($spec)->first();

		if(!$spec)
			abort(404);

		$make = \App\Make::whereName($make)->first();

		if(!$make)
			abort(404);

		$c = \App\Company::whereHas('makes', function($q) use($make){
			$q->where('make_id', $make->id);
		})
		->where('spec_id', $spec->id)
		->with('models')
		->take(6)
		->get();

		$models = \App\CarModel::where('make_id', $make->id)
		->has('companies')
		->get();

		$companies = array();

		foreach($c as $key => $val){

			$arr = array();

			$t = array();

			$arr['name'] = $val->name;
			$arr['about'] = $val->about;
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

		return view('pages.catalog.catalog-companies')
			->with(compact('spec', 'models', 'make', 'bread', 'companies'));

	}

	public function nospecs($make) {

		$make = \App\Make::whereName($make)->first();

		if(!$make)
			abort(404);

		$c = \App\Company::whereHas('makes', function($q) use($make){
			$q->where('make_id', $make->id);
		})
		->take(6)
		->get();

		$companies = array();

		foreach($c as $key => $val){

			$arr = array();

			$t = array();

			$arr['name'] = $val->name;
			$arr['about'] = $val->about;
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

		$models = \App\CarModel::where('make_id', $make->id)
		->has('companies')
		->get();

		$bread = ['nospecs' => $make];

		return view('pages.catalog.catalog-companies')
			->with('bread', $bread)
			->with('make', $make)
			->with('models', $models)
			->with('nospecs', true)
			->with('companies', $companies);

	}

	public function spec_make_models() {

	}

	public function nospecsModels() {


	}

}