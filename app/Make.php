<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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

	public function companies() {
		return $this->belongsToMany(
				'App\Company', 'company_makes', 
				'make_id', 'company_id'
			);
	}

	public function types() {
		return $this->belongsToMany(
				'App\Type', 'type_makes', 
				'make_id', 'type_id'
			);
	}

}
