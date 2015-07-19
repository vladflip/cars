<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $table = 'users';

	protected $fillable = ['name', 'email', 'password', 'confirmation_code'];

	protected $hidden = ['password', 'remember_token'];

	public function company() {
		return $this->hasOne('App\Company');
	}

	public function isAdmin() {
		return $this->is_admin;
	}

	public function likes() {
		return $this->belongsToMany(
				'App\User', 'feedback_likes', 
				'user_id', 'feedback_id'
			);
	}

	public function is_ready() {
		return $this->name && $this->ava;
	}

	public function email_provider() {
		$start = strrpos($this->email, '@');
		$provider = substr($this->email, $start + 1);
		return $provider;
	}

	public function dislikes() {
		return $this->belongsToMany(
				'App\User', 'feedback_dislikes', 
				'user_id', 'feedback_id'
			);
	}

	public function sendConfirmation($code) {
		\Mail::send('emails.verify', ['code' => $code], function($msg){
			$msg->to('vlad.flip.prg@gmail.com')
			->subject('Подтверждение почты');
		});
	}

	public function comments() {
		return $this->hasMany('App\Comment', 'user_id');
	}

	public function requests() {
		return $this->hasMany('App\Request', 'user_id');
	}

	public function responses_count() {
		// return $this->requests()->where('read', 0)->count();
		// responses whereIn this->requests
		return 1;
	}

}
