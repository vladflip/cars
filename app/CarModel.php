<?php namespace App;

use \SleepingOwl\Models\SleepingOwlModel as Model;

class CarModel extends Model {

	protected $table = 'models';

	protected $fillable = ['name', 'title'];

	public function make() {
		return $this->belongsTo('App\Make', 'make_id');
	}

	public function type() {
		return $this->belongsTo('App\Type', 'type_id');
	}

	public function getIdAttribute($id) {
		return intval($id);
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
		return self::where('make_id', $id)
		->first();
	}

	public static function getModelsArrayByMake($id) {
		$models = self::where('make_id', $id)->select('id')->get()->toArray();
		$array = [];
		foreach ($models as $model) {
			$array[] = $model['id'];
		}
		return $array;
	}

	public static function isInMake($model, $make) {
		$model = self::where('make_id', $make)->find($model);
		if($model)
			return true;
		return false;
	}

}
