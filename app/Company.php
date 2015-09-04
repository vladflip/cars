<?php namespace App;

use \SleepingOwl\Models\SleepingOwlModel as Model;

class Company extends Model {

	protected $table = 'companies';

	protected $fillable = ['name', 'address', 'phone', 'about', 'status'];

	public function user() {
		return $this->belongsTo('App\User', 'user_id');
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

		return $this->belongsToMany(
				'App\Request', 'company_requests', 
				'company_id', 'request_id'
			);

	}

}
