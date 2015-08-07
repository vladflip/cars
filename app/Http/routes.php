<?php

use Illuminate\Database\Eloquent\Model as Model;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.

|*/

get('/', [
	'as' => 'home', 
	'uses' => 'HomeController@index'
]);

get('page/{url}', function($url){

	$page = \App\Page::whereUrl($url)->first();

	if($page)
		return view('pages.page')->with('page', $page);
	else
		abort(404);

});

Route::group(['prefix' => 'user'], function(){

	get('profile', [
		'as' => 'profile',
		'uses' => 'UserController@profile',
		'middleware' => 'auth'
	]);

	post('create', [
		'as' => 'user-create',
		'uses' => 'UserController@create'
	]);
	
	post('auth', [
		'as' => 'user-auth',
		'uses' => 'UserController@authenticate'
	]);

	get('logout', [
		'as' => 'user-logout',
		function(){
			\Auth::logout();
			return redirect()->route('home');
		}
	]);

	get('repeat-message', [
		'as' => 'user-repeat-message',
		'uses' => 'UserController@repeat_message'
	]);

	get('verify/{code}', [
		'as' => 'user-verify',
		'uses' => 'UserController@verify',
		'middleware' => 'auth'
	]);

});

Route::group(['prefix' => 'catalog'], function(){

	get('/', [
		'as' => 'catalog', 
		'uses' => 'CatalogController@index'
	]);

	get('make/{allmakes}', [
		'as' => 'allmakes',
		'uses' => 'CatalogController@allmakes'
	]);

	get('make/{allmakes}/{model}', [
		'as' => 'allmakes-model',
		'uses' => 'CatalogController@allmakes_models'
	]);

	get('{spec}', [
		'as' => 'specs',
		'uses' => 'CatalogController@specs'
	]);

	get('{spec}/{make}', [
		'as' => 'make',
		'uses' => 'CatalogController@companies'
	]);

	get('{spec}/{make}/{model}', [
		'as' => 'spec-make-model',
		'uses' => 'CatalogController@spec_make_models'
	]);


});

Route::group(['prefix' => 'feedback'], function(){

	get('/', [

		'as' => 'feedback', 
		'uses' => 'FeedbackController@index'

	]);

	get('/id{id}', [

		'as' => 'mention',
		'uses' => 'FeedbackController@mention'

	])->where('id', '[0-9]+');

	get('{type}/{make}', [

		'as' => 'feedback-make',
		'uses' => 'FeedbackController@by_make'

	])->where(['type' => '[a-z+-]+', 'make' => '[a-z+-]+']);

	get('{type}/{make}/{model}', [

		'as' => 'feedback-model',
		'uses' => 'FeedbackController@by_model'

	])->where(['type' => '[a-z+-]+', 'make' => '[a-z+-]+']);

});

Route::group(['prefix' => 'api', 'middleware' => 'api'], function(){

	Route::group(['prefix' => 'user', 'middleware' => 'auth'], function() {

		post('edit', ['uses' => 'UserController@edit']);

		post('avatar', ['uses' => 'UserController@avatar']);

	});

	Route::group(['prefix' => 'feedback', 'middleware' => 'auth'], function() {

		post('create', ['uses' => 'FeedbackController@create']);

		post('vote', ['uses' => 'FeedbackController@vote']);

	});

	Route::group(['prefix' => 'company', 'middleware' => 'auth'], function() {

		post('create', ['uses' => 'CompanyController@create']);

		post('avatar', ['uses' => 'CompanyController@avatar']);

		post('edit', ['uses' => 'CompanyController@edit']);

	});

	Route::group(['prefix' => 'request', 'middleware' => 'auth'], function() {

		post('create', ['uses' => 'RequestController@create']);

		post('cancel', ['uses' => 'RequestController@cancel']);

	});

	Route::group(['prefix' => 'response', 'middleware' => 'auth'], function() {

		post('create', ['uses' => 'ResponseController@create']);

		post('cancel', ['uses' => 'ResponseController@cancel']);

	});

	Route::group(['prefix' => 'comments', 'middleware' => 'auth'], function() {

		post('create', ['uses' => 'CommentController@create']);

	});

	Route::group(['prefix' => 'admin'], function() {

		post('makesmodels', ['uses' => 'AdminController@makesmodels']);

	});

	get('get-makes', 'APIController@makes');

	get('get-makes-by-type-has-comps', 'APIController@makes_by_type_has_comps');

	get('get-makes-by-type', 'APIController@makes_by_type');

	get('get-models-by-make', 'APIController@models_by_make');

	get('live-makes', 'APIController@live_makes');

	get('get-companies-by-makes-and-specs', 'APIController@companies_by_makes_and_specs');

	get('get-companies-by-make', 'APIController@companies_by_make');

	get('get-companies-by-make-and-spec', 'APIController@companies_by_make_and_spec');

});