<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminController extends Controller {

	public function index() {

		return view('admin.index');

	}

	public function makes() {

		$makes = \App\Make::with('models')->take(20)->get();


		return view('admin.makesmodels')->with('makes', $makes);

	}

}
