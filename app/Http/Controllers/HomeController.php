<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	public function index() {

		$makes = \App\Make::has('companies')
		->orderBy('soviet', 'DESC')
		->orderBy('title', 'ASC')
		->get();

		return view('pages.home')->with('makes', $makes);

	}

}