<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ResponseController extends Controller {

	public function create() {

		$input = (object)\Input::all();

		if( $input->response == '' )
			return 'hello lamer';
		if( ! \App\Request::find($input->request) )
			return 'hello lamer';

		$response = new \App\Response;

		$response->text = $input->response;
		$response->company_id = \Auth::user()->company->id;
		$response->request_id = $input->request;

		$response->save();

	}

}
