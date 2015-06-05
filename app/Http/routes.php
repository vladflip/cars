<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

get('/', ['as' => 'home', function(){
	return view('pages.home');
}]);

get('/catalog', ['as' => 'catalog', function(){
	return view('pages.catalog');
}]);

get('/profile', ['as' => 'profile', function(){
	return view('pages.profile');
}]);

get('/feedback', ['as' => 'feedback', function(){
	return view('pages.feed');
}]);
