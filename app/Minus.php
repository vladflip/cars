<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Minus extends Model {

	protected $table = 'minuses';

	protected $fillable = ['text'];
	
	public $timestamps = false;

	public function feedback() {
		return $this->belongsTo('App\Feedback', 'feedback_id');
	}

}
