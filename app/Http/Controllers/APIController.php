<?php namespace App\Http\Controllers;

class APIController extends Controller {

	public function makes() {
		$m = \App\Make::select('id', 'title')->get();

		return $m;
	}

	public function makes_by_type() {

		$id = \Input::get('id');

		$m = \App\Make::select('id', 'title')
		->orderBy('soviet', 'DESC')
		->orderBy('title', 'ASC')
		->get();

		return $m;

	}

	public function makes_by_type_has_comps() {

		$id = \Input::get('id');

		$m = \App\Make::select('id', 'title')
		->whereHas('companies', function($q) use($id){
			$q->where('type_id', $id);
		})
		->get();

		return $m;

	}

	public function models_by_make() {

		$id = \Input::get('id');

		$m = \App\CarModel::where('make_id', '=', $id)
		->select('id', 'title')->get();

		return $m;
	}

	public function live_makes() {

		$typeId = \Input::get('type');

		$specId = \Input::get('spec');

		$makes = \App\Make::select('id')
		->whereHas('companies', function($q) use($specId, $typeId){	
			$q->where('spec_id', $specId);
			$q->where('type_id', $typeId);
		})
		->get();

		$ids = array();

		foreach ($makes as $k => $v) {
			$ids[] = $v->id;
		}

		return $ids;

	}

	public function companies_by_makes_and_specs() {

		$type = \Input::get('type');

		$skip = \Input::get('skip');

		$makes = \Input::get('makes');

		$spec = \Input::get('spec');

		$c = \App\Company::
			whereHas('makes', function($q) use($makes){
				$q->whereIn('id', $makes);
			})
			->where('type_id', $type)
			->where('spec_id', $spec)
			->with('type')
			->with('spec')
			->with('makes')
			->skip($skip)
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

		return json_encode($companies);

	}

	// in catalog
	public function companies_by_make_and_spec() {

		$skip = \Input::get('skip');

		$make = \Input::get('make');

		$spec = \Input::get('spec');

		$c = \App\Company::where('spec_id', '=', $spec)
			->whereHas('makes', function($q) use($make){
				$q->where('make_id', '=', $make);
			})
			->with('type')
			->with('spec')
			->with(['makes' => function($q){
				$q->select('title');
			}])
			->skip($skip)
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

		return $companies;

	}

	public function companies_by_make() {

		$skip = \Input::get('skip');

		$make = \Input::get('make');

		$c = \App\Company::whereHas('makes', function($q) use($make){
				$q->where('make_id', '=', $make);
			})
			->with('type')
			->with('spec')
			->with(['makes' => function($q){
				$q->select('title');
			}])
			->skip($skip)
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

		return $companies;

	}

}