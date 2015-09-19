<?php namespace App\Http\Controllers;

class CatalogController extends Controller {

	public function index() {

		$makes = \App\Make::whereHas('companies', function($q){
			$q->whereStatus(1);
		})
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
			$q->whereStatus(1);

		})->get();


		return view('pages.catalog.withspecs')
			->with('spec', $spec)
			->with('makes', $makes)
			->with('bread', $bread);

	}

	public function gatherJSON($c) {

		$companies = [];

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

		return $companies;

	}

	public function withspecs($spec, $make) {

		$spec = \App\Spec::whereName($spec)->first();

		if(!$spec)
			abort(404);

		$make = \App\Make::whereName($make)->first();

		if(!$make)
			abort(404);

		$c = \App\Company::whereHas('makes', function($q) use($make){
			$q->whereId($make->id);
		})
		->whereStatus(1)
		->where('spec_id', $spec->id)
		->with('models')
		->take(6)
		->get();

		$models = \App\CarModel::where('make_id', $make->id)
		->has('companies')
		->get();

		$companies = $this->gatherJSON($c);

		$bread = ['spec' => $spec, 'make' => $make];

		return view('pages.catalog.catalog-companies')
			->with(compact('spec', 'models', 'make', 'bread', 'companies'));

	}

	public function nospecs($make) {

		$make = \App\Make::whereName($make)->first();

		if(!$make)
			abort(404);

		$c = \App\Company::whereHas('makes', function($q) use($make){
			$q->whereId($make->id);
		})
		->whereStatus(1)
		->take(6)
		->get();

		$companies = $this->gatherJSON($c);

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

	public function withspecsModel($spec, $make, $model) {

		$spec = \App\Spec::whereName($spec)->first();

		if(!$spec)
			abort(404);

		$make = \App\Make::whereName($make)->first();

		if(!$make)
			abort(404);

		$model = \App\CarModel::whereName($model)
		->whereMakeId($make->id)
		->first();

		if(!$model)
			abort(404);

		$c = \App\Company::whereHas('models', function($q) use($model){
			$q->whereId($model->id);
		})
		->whereStatus(1)
		->where('spec_id', $spec->id)
		->take(6)
		->get();

		$companies = $this->gatherJSON($c);

		$bread = ['spec' => $spec, 'make' => $make];

		return view('pages.catalog.catalog-companies')
			->with(compact('spec', 'make', 'bread', 'companies'));

	}

	public function nospecsModel($make, $model) {

		$make = \App\Make::whereName($make)->first();

		if(!$make)
			abort(404);

		$model = \App\CarModel::whereName($model)
		->whereMakeId($make->id)
		->first();

		if(!$model)
			abort(404);

		$c = \App\Company::whereHas('models', function($q) use($model){
			$q->whereId($model->id);
		})
		->whereStatus(1)
		->take(6)
		->get();

		$companies = $this->gatherJSON($c);

		$bread = ['nospecs' => $make];

		return view('pages.catalog.catalog-companies')
			->with('bread', $bread)
			->with('make', $make)
			->with('nospecs', true)
			->with('companies', $companies);

	}

}