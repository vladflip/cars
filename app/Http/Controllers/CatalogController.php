<?php namespace App\Http\Controllers;

class CatalogController extends Controller {

	public function index() {

		return view('pages.catalog');

	}

	public function specs($name) {

		return view('pages.catalog')->with('current', $name);

	}

}