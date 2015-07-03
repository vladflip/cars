<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UserController extends Controller {

	public function profile() {

		return view('pages.company-profile');

	}

	public function create() {

		$input = \Input::all();

		return $input;

	}

	public function authenticate() {

		$input = (object)\Input::all();

		if(\Auth::attempt(['email' => $input->email, 'password' => $input->password], true)){

			return redirect()->route('profile');
			
		} else {

			// return view auth.error
			return 'нет такого юзера';

		}

	}

}
