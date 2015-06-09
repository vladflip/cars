<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model {

	protected $table = 'photos';

	public function feedback() {
		return $this->belongsTo('App\Feedback', 'feedback_id');
	}

}
