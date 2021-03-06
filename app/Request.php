<?php namespace App;

use \SleepingOwl\Models\SleepingOwlModel as Model;

class Request extends Model {

	protected $table = 'requests';

	protected $fillable = ['status', 'text'];

	public function type() {
		return $this->belongsTo('App\Type', 'type_id');
	}

	public function make() {
		return $this->belongsTo('App\Make', 'make_id');
	}

	public function getReadAttribute($read) {
		return intval($read);
	}

	public function getIdAttribute($read) {
		return intval($read);
	}

	public function model() {
		return $this->belongsTo('App\CarModel', 'model_id');
	}

	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

	public function rooms() {
		return $this->hasMany('App\Room', 'request_id');
	}

}
