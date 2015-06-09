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

get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::group(['prefix' => 'catalog'], function(){

	get('/', [
		'as' => 'catalog', 
		'uses' => 'CatalogController@index'
	]);

	get('/make/{allmake}', [
		'as' => 'allmake',
		'uses' => 'CatalogController@allmake'
	])->where(['allmake' => '[a-z+]+']);

	get('{spec}', [
		'as' => 'specs',
		'uses' => 'CatalogController@specs'
	])->where('spec', '[a-z]+');

	get('{spec}/{make}', [
		'as' => 'make',
		'uses' => 'CatalogController@companies'
	])->where(['spec' => '[a-z]+', 'make' => '[a-z+]+']);


});

get('/profile', ['as' => 'profile', function(){
	return view('pages.profile');
}]);

get('/feedback', ['as' => 'feedback', function(){
	return view('pages.feed');
}]);
