<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Spec extends Model {

	protected $table = 'specs';

	protected $fillable = ['title', 'name'];

	public function companies() {
		return $this->hasMany('App\Company', 'spec_id');
	}

}
