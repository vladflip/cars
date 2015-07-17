<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RequestController extends Controller {

	public function create() {

		if( ! \Auth::user()->is_ready() )
			return 'hello lamer';

		

	}

}
