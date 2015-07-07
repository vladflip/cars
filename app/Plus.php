<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Plus extends Model {

	protected $table = 'pluses';

	protected $fillable = ['text'];

	public $timestamps = false;

	public function feedback() {
		return $this->belongsTo('App\Feedback', 'feedback_id');
	}

}
