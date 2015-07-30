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

	public function requests() {

		return $this->belongsToMany(
				'App\Request', 'company_requests', 
				'company_id', 'request_id'
			);

	}

	public function freshRequests() {

		$id = $this->id;

		$models = $this->models()->select('id')->get();
		$ids = [];

		foreach ($models as $model) {
			$ids[] = $model['id'];
		}

		$requests = \App\Request::select('id')
		->whereIn('model_id', $ids)
		->get();

		return $requests;

	}

	public function updateRequests() {

		$freshRequests = $this->freshRequests();

		$attachedRequests = $this->requests()->select('id')->get();

		$freshIds = [];
		$attachedIds = [];

		foreach ($freshRequests as $request) {
			
			$freshIds[] = $request->id;

		}
		foreach ($attachedRequests as $request) {
			
			$attachedIds[] = $request->id;

		}

		if( $freshRequests->count() != $attachedRequests->count() ) {

			$ids = array_diff($freshIds, $attachedIds);

			foreach ($ids as $id) {
				$this->requests()->attach($id);
			}	

		}

	}

}
