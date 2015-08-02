<?php namespace App;

use \SleepingOwl\Models\SleepingOwlModel as Model;

class Response extends Model {

	protected $table = 'responses';

	public function request() {
		return $this->belongsTo('App\Request', 'request_id');
	}

	public function company() {
		return $this->belongsTo('App\Company', 'company_id');
	}

}
