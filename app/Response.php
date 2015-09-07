<?php namespace App;

use \SleepingOwl\Models\SleepingOwlModel as Model;

class Response extends Model {

	protected $table = 'responses';

	protected $fillable = ['text'];

	public function room() {
		return $this->belongsTo('App\Room', 'room_id');
	}

	public function company() {
		return $this->belongsTo('App\Company', 'company_id');
	}

}
