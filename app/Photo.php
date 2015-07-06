<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model {

	protected $table = 'photos';

	protected $fillable = ['src'];

	public $timestamps = false;

	public function feedback() {
		return $this->belongsTo('App\Feedback', 'feedback_id');
	}

}
