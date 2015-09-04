<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RequestController extends Controller {

	public function create() {

		if( ! \Auth::user()->is_ready() )
			return 'hello lamer';

		$input = (object)\Input::all();

		$request = new \App\Request;

		$request->type_id = $input->type;

		if( ! $input->new && ! $input->old )
			return 'hello lamer';
		else {
			$request->new = $input->new;
			$request->old = $input->old;
		}

		if(\App\Make::isInType($input->make, $input->type))
			$request->make_id = $input->make;
		else
			return 'hello lamer';

		if(\App\CarModel::isInMake($input->model, $input->make))
			$request->model_id = $input->model;
		else
			return 'hello lamer';

		if( ! $input->year )
			return 'hello lamer';
		else
			$request->year = $input->year;

		if( ! $input->more )
			return 'hello lamer';
		else
			$request->text = $input->more;

		$request->user_id = \Auth::id();

		$request->save();

		return $request;

	}

	public function show($id) {

		if(\Auth::user()->company && \Auth::user()->company->status){

			

		} else {

			

		}

	}

	public function cancel() {

		$id = \Input::get('id');

		$request = \App\Request::find($id);

		if( $request->user_id != \Auth::id() )
			return 'hello lamer';

		$request->canceled_by_user = true;

		$request->save();

	}

}
