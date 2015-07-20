<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

	protected $table = 'companies';

	protected $fillable = ['name', 'address', 'phone', 'about'];

	private $requests = null;

	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

	public function type() {
		return $this->belongsTo('App\Type', 'type_id');
	}

	public function spec() {
		return $this->belongsTo('App\Spec', 'spec_id');
	}

	public function models() {
		return $this->belongsToMany(
				'App\CarModel', 'company_models', 
				'company_id', 'model_id'
			);
	}

	public function makes() {
		return $this->belongsToMany(
				'App\Make', 'company_makes', 
				'company_id', 'make_id'
			);
	}

	// get all requests by type and make and model of company
	public function requests() {

		$id = $this->id;

		if($this->requests)
			return $this->requests;
		
		else {
			$models = $this->models()->select('id')->get();
			$ids = [];

			foreach ($models as $model) {
				$ids[] = $model['id'];
			}

			$this->requests = \App\Request::whereIn('model_id', $ids)
			->with('user')
			->with(['responses' => function($q) use($id){
				$q->whereCompanyId($id);
			}])
			->orderBy('created_at', 'desc')
			->get();

			return $this->requests;
		}		

	}

	public function setReadRequests() {
		foreach ($this->requests() as $request) {
			if( ! $this->readRequests->contains($request->id))
				$this->readRequests()->attach($request->id);
		}
	}

	public function readRequests() {
		return $this->belongsToMany(
				'App\Request', 'read_requests', 
				'company_id', 'request_id'
			);
	}

	public function requestsCount() {

		$ids = [];

		$requests = $this->readRequests;

		foreach ($requests as $request) {
			$ids[] = $request->id;
		}

		$models = $this->models()->select('id')->get();
		$modelIds = [];

		foreach ($models as $model) {
			$modelIds[] = $model['id'];
		}

		return \App\Request::whereIn('model_id', $modelIds)
		->whereNotIn('id', $ids)
		->count();

	}

}
