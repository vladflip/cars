<?php namespace App;

use \SleepingOwl\Models\SleepingOwlModel as Model;

class Type extends Model {

	protected $table = 'types';

	protected $fillable = ['name', 'icon', 'title', 'icon_active'];

	public function companies() {
		return $this->hasMany('App\Company', 'type_id');
	}

	public function models() {
		return $this->hasMany('App\CarModel', 'type_id');
	}

	public function feedbacks() {
		return $this->hasMany('App\Feedback', 'type_id');
	}

}
