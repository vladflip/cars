<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model {

	protected $table = 'responses';

	public function request() {
		return $this->belongsTo('App\Request', 'request_id');
	}

	public function company() {
		return $this->belongsTo('App\Company', 'company_id');
	}

}
