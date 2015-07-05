<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $table = 'users';

	protected $fillable = ['name', 'address', 'phone', 'about'];

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

	public function dislikes() {
		return $this->belongsToMany(
				'App\User', 'feedback_dislikes', 
				'user_id', 'feedback_id'
			);
	}

	public function comments() {
		return $this->hasMany('App\Comment', 'user_id');
	}

	public function requests() {
		return $this->hasMany('App\Request', 'user_id');
	}
}
