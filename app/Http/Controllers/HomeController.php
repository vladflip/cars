<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	public function index() {

		$makes = \App\Make::all();

		return view('pages.home')->with('makes', $makes);

	}

}