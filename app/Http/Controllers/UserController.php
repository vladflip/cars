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

		$input = (object)\Input::all();

		$validator = \Validator::make(
			['email' => $input->email],
			['email' => 'required|email|unique:users']

		);

		if($validator->fails()){
			return 'hello lamer';
		}

		$code = md5(\Hash::make($input->email));

		$user = \App\User::create([
			'email' => $input->email,
			'password' => \Hash::make($input->password),
			'confirmation_code' => $code
		]);

		\Auth::login($user);

		\Mail::send('emails.verify', ['code' => $code], function($msg) use ($user){
			$msg->to($user->email)
			->subject('Подтверждение почты');
		});

		return redirect()->route('profile');

	}

	public function verify($code) {

		$user = \App\User::where('confirmation_code', $code)->first();

		if(!$user) {
			return redirect()->route('home');
		}

		$user->confirmed = true;

		$user->confirmation_code = null;

		$user->save();

		return redirect()->route('profile');

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
