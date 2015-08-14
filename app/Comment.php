<?php namespace App;

use \SleepingOwl\Models\SleepingOwlModel as Model;

class Comment extends Model {

	protected $table = 'comments';

	public $fillable = ['text', 'status'];

	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

	public function feedback() {
		return $this->belongsTo('App\Feedback', 'feedback_id');
	}

}
