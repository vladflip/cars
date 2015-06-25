<?php namespace App;

use Illuminate\Database\Eloquent\Model as Model;

class CarModel extends Model {

	protected $table = 'models';

	protected $fillable = ['name', 'title'];

	public function make() {
		return $this->belongsTo('App\Make', 'make_id');
	}

	public function feedbacks() {
		return $this->hasMany('App\Feedback', 'model_id');
	}
	
	public static function exists($name) {
		return self::whereName($name)->first();
	}

	public function types() {
		return $this->belongsToMany(
				'App\Type', 'types_models', 
				'model_id', 'type_id'
			);
	}

}
