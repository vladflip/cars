<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CompanyController extends Controller {

	public function create() {

		// if user has company return hello lamer
		if( \Auth::user()->company )
			return 'hello lamer';

		$input = (object)\Input::all();

		$company = new \App\Company;

		// =============================

		if( ! isset($input->name) || ! $input->name )
			return 'hello lamer';

		$company->name = $input->name;

		// =============================

		if( ! isset($input->address) || ! $input->address )
			return 'hello lamer';

		$company->address = $input->address;

		// =============================

		if( ! isset($input->phone) || ! $input->phone )
			return 'hello lamer';

		$company->phone = $input->phone;

		// =============================

		if( ! isset($input->about) || ! $input->about )
			return 'hello lamer';

		$company->about = $input->about;

		// =============================

		if( ! isset($input->logo) || ! $input->logo )
			return 'hello lamer';

		$image = \Image::make( $input->logo );

		if($image->height() < 115 or $image->height() > 7000) {
			return 'hello lamer';
		}

		if($image->width() < 115 or $image->width() > 7000) {
			return 'hello lamer';
		}

		$name = md5(\Hash::make($input->logo . \Auth::id()));

		$dirname = 'img/user' . \Auth::id();

		$fullname = $dirname . '/' . $name . '.jpg';

		if( ! file_exists($dirname) ){
			mkdir($dirname, 0777, true);
		}

		if( file_exists($company->logo) ){
			unlink($company->logo);
		}

		$company->logo = $fullname;

		$company->user_id = \Auth::id();

		if( $this->associate_type_and_spec($company, $input) )
			return 'hello lamer';

		$image->save($fullname);
		
		return $company;

	}

	public function associate_type_and_spec ($company, $input) {

		// check type and spec
		if( ! \App\Type::find($input->type) )
			return 'hello lamer';
		if( ! \App\Spec::find($input->spec) )
			return 'hello lamer';

		$company->type_id = $input->type;
		$company->spec_id = $input->spec;


		if( $this->attach_makes_models($company, $input->makesmodels) )
			return 'hello lamer';

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

		return 'fuck';

	}

}
