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

	public static function getMakeByType($id) {
		return self::whereHas('types', function($q) use($id){
			$q->whereId($id);
		})
		->first();
	}

	public static function isInType($make, $type) {
		$make = self::whereHas('types', function($q) use($type){
			$q->whereId($type);
		})
		->find($make);

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
