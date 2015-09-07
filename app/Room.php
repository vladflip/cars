<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model {

	protected $table = 'rooms';

	public $timestamps = false;

	public function request() {
		return $this->belongsTo('App\Request', 'request_id');
	}

	public function company() {
		return $this->belongsTo('App\Company', 'company_id');
	}

	public function response() {
		return $this->hasOne('App\Response');
	}

}
