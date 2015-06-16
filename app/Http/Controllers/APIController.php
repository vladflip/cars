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

		$name = \Input::get('name');

		$id = \Input::get('id');

		if(!is_numeric($id))
			return 'fuck';

		if($name == 'type') {

			$m = \App\Make::select('id', 'title')
				->whereHas('types', function($q) use($id){
					$q->where('type_id', '=', $id);
				})
				->get();

			return $m;

		}
		elseif($name == 'spec'){

			$m = \App\Make::select('id', 'title')
				->whereHas('companies', function($q) use($id){
					$q->where('spec_id', '=', $id);
				})
				->get();

			return $m;
		}

		abort(404);

	}

}