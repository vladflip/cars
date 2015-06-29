<?php namespace App;

use Illuminate\Database\Eloquent\Model as Model;

class CarModel extends Model {

	protected $table = 'models';

	protected $fillable = ['name', 'title'];

	public function make() {
		return $this->belongsTo('App\Make', 'make_id');
	}

	public function type() {
		return $this->belongsTo('App\Type', 'type_id');
	}

	public function companies() {
		return $this->belongsToMany(
				'App\Company', 'company_models', 
				'model_id', 'company_id'
			);
	}

	public function feedbacks() {
		return $this->hasMany('App\Feedback', 'model_id');
	}
	
	public static function exists($name) {
		return self::whereName($name)->first();
	}

	public static function getModelByMake($id) {
		$model = self::where('make_id', $id)
		->first();

		return $model;
	}

}
