<?php namespace App\Http\Controllers;

class APIController extends Controller {

	public function makes() {

		$id = \Input::get('id');

		$m = \App\Make::whereHas('types', function($q) use($id){
			$q->where('type_id', '=', $id);
		})
		->select('id', 'title')->get();

		return $m;

	}

	public function models() {

		$id = \Input::get('id');

		$m = \App\CarModel::where('make_id', '=', $id)
		->select('id', 'title')->get();

		return $m;
	}

}