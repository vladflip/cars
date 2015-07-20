<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use \Auth;

use Illuminate\Http\Request;

class UserController extends Controller {

	public function profile() {

		if(Auth::user()->company){

			$user = \App\User::with(['company' => function($q){
				$q->with('spec');
				$q->with('type');
				$q->with('makes');
			}])->find(Auth::id());

			$requestsCount = \App\Singleton::requestsCount();

			return view('pages.company-profile')
			->with('user', $user)
			->with('requests', $user->company->requests())
			->with('requestsCount', $requestsCount);

		} else {

			$user = \App\User::with(['requests' => function($q){

				$q->with(['responses' => function($q){
					$q->orderBy('created_at', 'desc');
					$q->with('company');
				}]);

				$q->orderBy('created_at', 'desc');

			}])
			->find(Auth::id());

			$user->setReadResponses();

			return view('pages.user-profile')->with('user', $user);

		}

		echo 'fuck';

	}

	public function edit() {

		$data = \Input::all();

		$user = \Auth::user();

		$user->update($data);

		return $user;

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

	public function avatar() {

		$input = (object)\Input::all();

		$image = \Image::make($input->src);

		$coords = (object)$input->coords;

		$user = \Auth::user();

		if($image->height() < 115 or $image->height() > 7000) {
			return 'hello lamer';
		}

		if($image->width() < 115 or $image->width() > 7000) {
			return 'hello lamer';
		}

		$image->crop( (int)$coords->w, (int)$coords->h, (int)$coords->x, (int)$coords->y );

		$name = md5(\Hash::make($input->src . \Auth::id()));

		$dirname = 'img/user' . \Auth::id();

		$fullname = $dirname . '/' . $name . '.jpg';

		if( ! file_exists($dirname) ){
			mkdir($dirname, 0777, true);
		}

		if( file_exists($user->ava) ){
			unlink($user->ava);
		}

		$user->ava = $fullname;

		$user->save();

		$image->save($fullname);

		return \URL::to('/') . '/' . $user->ava;

	}

}
