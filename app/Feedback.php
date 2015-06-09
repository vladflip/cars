<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model {

	protected $table = 'feedback';

	public function type() {
		return $this->belongsTo('App\Type', 'type_id');
	}

	public function make() {
		return $this->belongsTo('App\Make', 'make_id');
	}

	public function model() {
		return $this->belongsTo('App\Model', 'model_id');
	}

	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

	public function pluses() {
		return $this->hasMany('App\Plus', 'feedback_id');
	}

	public function minuses() {
		return $this->hasMany('App\Minus', 'feedback_id');
	}

	public function photos() {
		return $this->hasMany('App\Photo', 'feedback_id');
	}

	public function likes() {
		return $this->belongsToMany(
				'App\User', 'feedback_likes', 
				'feedback_id', 'user_id'
			);
	}

	public function dislikes() {
		return $this->belongsToMany(
				'App\User', 'feedback_dislikes', 
				'feedback_id', 'user_id'
			);
	}

	public function comments() {
		return $this->hasMany('App\Comment', 'feedback_id');
	}
}
