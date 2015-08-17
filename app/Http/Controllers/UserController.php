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

			$company = $user->company;

			$requests = $company->requests()
				->with(['responses' => function($q) use ($company){
					$q->whereCompanyId($company->id);
				}])
				->with('user')
				->withPivot(['read', 'replied', 'canceled_by_company', 'updated_at'])
				->orderBy('pivot_replied')
				->orderBy('pivot_updated_at', 'desc')
				->orderBy('created_at', 'desc')
				->get();

			$company->setReadRequests();

			return view('pages.company-profile')
				->with('user', $user)
				->with('requests', $requests);

		} else {

			$user = \App\User::with(['requests' => function($q){

				$q->with(['responses' => function($q){
					$q->orderBy('created_at', 'desc');
					$q->with('company');
				}]);

				$q->orderBy('updated_at', 'desc');

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

	public function changeEmail() {

		$newEmail = \Input::get('email');

		echo $newEmail;

		$user = Auth::user();

		$code = md5(\Hash::make($user->email));

		$user->confirmation_code = $code;
		$user->confirmed = 0;
		$user->save();

		\Mail::send('emails.verify', ['code' => $code], function($msg) use ($user){
			$msg->to($user->email)
			->subject('Подтверждение почты');
		});

	}

	public function repeat_message() {

		$user = Auth::user();

		if( $user->confirmed ) {
			return redirect()->route('home');
		}

		$code = md5(\Hash::make($user->email));

		$user->confirmation_code = $code;
		$user->save();

		\Mail::send('emails.verify', ['code' => $code], function($msg) use ($user){
			$msg->to($user->email)
			->subject('Подтверждение почты');
		});	

		return redirect()->route('profile');

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

		\Mail::queue('emails.verify', ['code' => $code], function($msg) use ($user){
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
