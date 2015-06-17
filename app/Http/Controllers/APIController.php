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

		$type = \App\Make::select('id')
			->whereHas('types', function($q) use($typeId){
				$q->where('type_id', '=', $typeId);
			})
			->get();

		$def = array();

		foreach($type as $k => $v) {

			$def[] = $v->id;

		}

		$specs = \App\Make::select('id')
			->whereHas('companies', function($q) use($specIds){
				$q->whereIn('spec_id', $specIds);
			})
			->get();

		foreach($specs as $k => $v) {

			$def[] = $v->id;

		}


		$makes = array_unique($def, SORT_NUMERIC);

		return $makes;

	}

	public function companies_by_makes() {

		$ids = \Input::get('ids');

		

	}

}