<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;

use Illuminate\Http\Request;

class ResponseController extends Controller {

	public function create() {

		$input = (object)\Input::all();

		$company = \Auth::user()->company;

		if( $input->response == '' )
			return 'hello lamer';

		$request = \App\Request::find($input->request);

		if( ! $request )
			return 'hello lamer';

		$response = new \App\Response;

		$response->text = $input->response;
		$response->company_id = $company->id;
		$response->request_id = $input->request;

		$response->save();

		$company->requests()->updateExistingPivot($request->id, [
			'replied' => true,
			'updated_at' => new Carbon
		]);

		$request->touch();

	}

}
