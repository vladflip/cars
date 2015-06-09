<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model {

	protected $table = 'types';

	public function companies() {
		return $this->hasMany('App\Company', 'type_id');
	}

	public function makes() {
		return $this->belongsToMany(
				'App\Make', 'type_makes', 
				'type_id', 'make_id'
			);
	}

	public function feedbacks() {
		return $this->hasMany('App\Feedback', 'type_id');
	}

}
