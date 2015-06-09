<?php namespace App\Http\Controllers;

class CatalogController extends Controller {

	public function index() {

		$makes = \App\Make::all();

		return view('pages.catalog')->with('makes', $makes);

	}

	public function specs($name) {

		return view('pages.catalog')->with('current', $name);

	}

}