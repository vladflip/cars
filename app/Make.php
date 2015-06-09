<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Make extends Model {

	protected $table = 'makes';

	public function types() {
		return $this->belongsToMany(
				'App\Make', 'type_makes', 
				'make_id', 'type_id'
			);
	}

	public function companies() {
		return $this->belongsToMany(
				'App\Company', 'company_makes', 
				'make_id', 'company_id'
			);
	}

	public function models() {
		return $this->hasMany('App\Model', 'make_id');
	}

	public function feedbacks() {
		return $this->hasMany('App\Feedback', 'make_id');
	}
}
