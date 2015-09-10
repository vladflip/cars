<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CompanyController extends Controller {

	public function create() {

		if( $msg = $this->makeValidation() )
			return $msg;

		$image = $this->storeImage();

		if($image->failed)
			return $image->messages;

		$company = new \App\Company(\Input::all());

		$company->logo = $image->src;

		$company->user_id = \Auth::id();
		$company->type_id = \Input::get('type');
		$company->spec_id = \Input::get('spec');

		if( $this->attach_makes_models($company, \Input::get('makesmodels')) )
			return 'hello lamer';
		
		return $company;
		return route('profile');

	}

	public function makeValidation() {

		if( ! \Auth::user()->is_ready() )
			return 'not ready';

		if( \Auth::user()->company )
			return 'has company';

		$validator = \Validator::make(\Input::all(), [
			'name' => 'required',
			'address' => 'required',
			'phone' => 'required',
			'about' => 'required',
			'logo' => 'required',
			'type' => 'required|exists:types,id',
			'spec' => 'required|exists:specs,id'
		]);

		if($validator->fails())
			return $validator->failed();

	}

	public function storeImage() {

		$logo = \Input::get('logo');

		$image = \Image::make( $logo );

		$result = new stdClass;
		$result->messages = array();
		$result->failed = false;

		if($image->height() < 115 or $image->height() > 7000) {
			$result->messages[] = 'height doesnt fits';
			$result->failed = true;
		}

		if($image->width() < 115 or $image->width() > 7000) {
			$result->messages[] = 'width doesnt fits';
			$result->failed = true;
		}

		$name = md5(\Hash::make($logo . \Auth::id()));

		$dirname = 'img/user' . \Auth::id();

		$src = $dirname . '/' . $name . '.jpg';

		if( ! file_exists($dirname) ){
			mkdir($dirname, 0777, true);
		}

		$image->save($src, 100);

		$result->src = $src;

	}

	public function attach_makes_models (\App\Company $company, $makesmodels) {

		// check for validity
		foreach ($makesmodels as $m) {
			$make = (object)$m;
			
			if( ! \App\Make::isInType($make->id, $company->type_id))
				return 'make not in type';


			if( $make->models != 0 )

				foreach ($make->models as $model) {

					if( ! \App\CarModel::isInMake($model, $make->id) )
						return 'model is not in make';

				}

		}

		// attach

		$company->save();

		foreach ($makesmodels as $m) {

			$make = (object)$m;

			$company->makes()->attach($make->id);

			if( $make->models == 0 ) {  // all models

				$company->models()->attach( \App\CarModel::getModelsArrayByMake($make->id) );

			} else {

				foreach ($make->models as $model) {
					
					$company->models()->attach($model);

				}

			}

		}

	}

	public function avatar() {

		$input = (object)\Input::all();

		$image = \Image::make($input->src);

		$coords = (object)$input->coords;

		$company = \Auth::user()->company;

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

		if( file_exists($company->logo) ){
			unlink($company->logo);
		}

		$company->logo = $fullname;

		$company->save();

		$image->save($fullname);

		return \URL::to('/') . '/' . $company->logo;

	}

	public function edit() {

		$data = \Input::all();

		$company = \Auth::user()->company;

		$company->update($data);

		return $company;
		
	}

	public function signUp() {

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
			'password' => \Hash::make($input->pass),
			'confirmation_code' => $code
		]);

		\Auth::login($user);

		\Mail::queue('emails.verify', ['code' => $code], function($msg) use ($user){
			$msg->to($user->email)
			->subject('Подтверждение почты');
		});

		echo $this->create(), "\n\r";

		return route('profile');

	}

}
