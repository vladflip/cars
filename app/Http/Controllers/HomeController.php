<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	public function index() {

		$makes = \App\Make::has('companies')
		->orderBy('soviet', 'DESC')
		->orderBy('title', 'ASC')
		->get();

		$types = \App\Type::count();

		$makesTypes = [];

		for($i=1; $i<=$types; $i++) {
			$makesTypes[] = \App\Make::select('id')
				->whereHas('companies', function($q) use($i){
					$q->where('type_id', $i);
				})
				->get();
		}

		$ids = array();

		foreach ($makesTypes as $v) {

			$tmp = [];
			
			foreach ($v as $value) {
				$tmp[] = $value->id;
			}

			$ids[] = json_encode($tmp);

		}

		return view('pages.home')
		->with('ids', $ids)
		->with('makes', $makes);

	}

}