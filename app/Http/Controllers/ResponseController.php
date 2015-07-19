<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ResponseController extends Controller {

	public function create() {

		$input = \Input::all();

		return $input;

	}

}
