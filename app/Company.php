<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

	protected $table = 'companies';

	protected $fillable = ['name', 'address', 'phone', 'about'];

	public function user() {
		return $this->hasOne('App\User', 'user_id');
	}

	public function type() {
		return $this->belongsTo('App\Type', 'type_id');
	}

	public function spec() {
		return $this->belongsTo('App\Spec', 'spec_id');
	}

	public function models() {
		return $this->belongsToMany(
				'App\CarModel', 'company_models', 
				'company_id', 'model_id'
			);
	}

	public function makes() {
		return $this->belongsToMany(
				'App\Make', 'company_makes', 
				'company_id', 'make_id'
			);
	}

	public function requests() {
		// get all requests by type and make and model of company
		return false;
	}

	public function requests_count() {

		return $this->requests()->whereRead(0)->count();

	}

}
