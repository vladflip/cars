<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RoomController extends Controller {

	public function index($id) {

		$room = \App\Room::with('request.user')
		->with('company')
		->find($id);

		if( ! $room)
			abort(404);

		$company = false;

		if( \Auth::user()->company ) {

			if( \Auth::user()->company->id != $room->company->id )
				return redirect()->route('home');

			$company = true;

		} else {

			if( \Auth::user()->id != $room->request->user->id ) 
				return redirect()->route('home');

		}



		return view('pages.room')
			->with('company', $company)
			->with('request', $room->request)
			->with('room', $room)
			->with('user', \Auth::user());

	}

}
