<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RoomController extends Controller {

	public function index($id) {

		$room = \App\Room::with('request.user')
		->with('company')
		->with(['response' => function($q){
			$q->with('photos');
		}])
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

		$opts = [
			['1'],
			['2'],
			['21','12'],
			['22', '13', '31'],
			['23', '32', '14', '41'],
			['33', '42', '51', '15', '24'],
			['25', '34', '52', '43'],
			['35', '53'],
			['45', '54'],
			['55']
		];

		$option = 0;

		if(count($room->response->photos)>0){
			$row = count($room->response->photos)-1;
			$col = count($opts[$row]);
			$randOption = rand(0, $col-1);

			$option = $opts[$row][$randOption];
		}

		return view('pages.room')
			->with('company', $company)
			->with('request', $room->request)
			->with('room', $room)
			->with('layout', $option)
			->with('user', \Auth::user());

	}

}
