<?php namespace App\Http\Controllers;

class APIController extends Controller {

	public function makes() {
		$m = \App\Make::select('id', 'title')->get();

		return $m;
	}

	public function makes_by_type() {

		$id = \Input::get('id');

		$m = \App\Make::whereHas('types', function($q) use($id){
			$q->where('type_id', '=', $id);
		})
		->select('id', 'title')->get();

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

		$specIds = \Input::get('specs');

		$makes = \App\Make::select('id')
			->whereHas('companies', function($q) use ($typeId, $specIds){
				$q->where('type_id', '=', $typeId);
				$q->whereIn('spec_id', $specIds);
			})
			->get();
		$ids = array();

		foreach ($makes as $k => $v) {
			$ids[] = $v->id;
		}

		return $ids;

	}

	public function companies_by_makes() {

		$type = \Input::get('type');

		$skip = \Input::get('skip');

		$makes = \Input::get('makes');

		$specs = \Input::get('specs');

		$c = \App\Company::where('type_id', '=', $type)
			->whereIn('spec_id', $specs)
			->whereHas('makes', function($q) use($makes){
				$q->whereIn('make_id', $makes);
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

		return json_encode($companies);

	}

}