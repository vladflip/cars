<?php namespace App;

use \SleepingOwl\Models\SleepingOwlModel as Model;

class Make extends Model {

	protected $table = 'makes';

	protected $fillable = ['name', 'title', 'soviet'];

	public static function exists($name) {
		return self::whereName($name)->first();
	}

	public function getIdAttribute($id) {
		return intval($id);
	}

	public function models() {
		return $this->hasMany('App\CarModel', 'make_id');
	}

	public function feedbacks() {
		return $this->hasMany('App\Feedback', 'make_id');
	}

	public static function isInType($id, $type) {
		$make = self::whereHas('models', function($q) use($type){
			$q->whereTypeId($type);
		})
		->find($id);

		if($make)
			return true;
		return false;
	}

	public function companies() {
		return $this->belongsToMany(
				'App\Company', 'company_makes', 
				'make_id', 'company_id'
			);
	}

}
