<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponsePhoto extends Model {

	protected $table = 'response_photos';

	protected $fillable = ['src'];

	public $timestamps = false;

	public function response(){
		return $this->belongsTo('App\Response', 'response_id');
	}

}
