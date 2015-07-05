<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use \Auth;

use Illuminate\Http\Request;

class UserController extends Controller {

	public function profile() {

		$user = \App\User::with('requests', 'company')
		->find(Auth::id());

		if($user->company){

			return view('pages.company-profile');

		} else {

			return view('pages.user-profile')->with('user', $user);

		}

	}

	public function create() {

		$input = \Input::all();

		return $input;

	}

	public function authenticate() {

		$input = (object)\Input::all();

		if(Auth::attempt(['email' => $input->email, 'password' => $input->password], true)){

			return redirect()->route('profile');

		} else {

			// return view auth.error
			return 'нет такого юзера';

		}

	}

}
