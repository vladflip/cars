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

get('/git-pull', function(){
	`git pull`;
	return redirect()->route('home');
});

get('check', function(){
	var_dump(\Config::get('makemodel'));
});

get('page/{url}', function($url){

	$page = \App\Page::whereUrl($url)->first();

	if($page)
		return view('pages.page')->with('page', $page);
	else
		abort(404);

});

get('contacts', ['as' => 'contacts', 'uses' => function() {
	return view('pages.contacts');
}]);

get('room/id{id}', [
	'uses' => 'RoomController@index',
	'as' => 'room',
	'middleware' => 'auth'
]);

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

	get('make/{make}', [
		'as' => 'catalog-nospecs',
		'uses' => 'CatalogController@nospecs'
	]);

	get('make/{make}/{model}', [
		'as' => 'catalog-nospecs-model',
		'uses' => 'CatalogController@nospecsModel'
	]);

	get('{spec}', [
		'as' => 'specs',
		'uses' => 'CatalogController@specs'
	]);

	get('{spec}/{make}', [
		'as' => 'make',
		'uses' => 'CatalogController@withspecs'
	]);

	get('{spec}/{make}/{model}', [
		'as' => 'spec-make-model',
		'uses' => 'CatalogController@withspecsModel'
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

	post('user/auth', [
			'as' => 'user-auth',
			'uses' => 'UserController@authenticate'
		]);

	post('company/create-signup', ['uses' => 'CompanyController@signUp']);

	post('contacts/send', [
		'uses' => 'APIController@contacts'
	]);

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

	});

	Route::group(['prefix' => 'response', 'middleware' => 'auth'], function() {

		post('create', ['uses' => 'ResponseController@create']);

	});

	Route::group(['prefix' => 'comments', 'middleware' => 'auth'], function() {

		post('create', ['uses' => 'CommentController@create']);

	});

	Route::group(['prefix' => 'settings', 'middleware' => 'auth'], function() {

		post('email', ['uses' => 'UserController@changeEmail']);

		post('password', ['uses' => 'UserController@changePassword']);

	});

	Route::group(['prefix' => 'admin'], function() {

		post('makesmodels', ['uses' => 'AdminController@makesmodels']);

		post('remove-make', ['uses' => 'AdminController@removeMake']);

		post('remove-model', ['uses' => 'AdminController@removeModel']);

		post('create-make', ['uses' => 'AdminController@createMake']);

	});

	get('get-makes', 'APIController@makes');

	get('get-makes-by-type-has-comps', 'APIController@makes_by_type_has_comps');

	get('get-makes-by-type', 'APIController@makes_by_type');

	get('get-makes-by-spec-type', 'APIController@specTypeMakes');

	get('get-makes-by-type-ids', 'APIController@makesByTypeIds');

	get('get-models-by-make', 'APIController@models_by_make');

	get('live-makes', 'APIController@live_makes');

	get('get-companies-by-makes-and-specs', 'APIController@companies_by_makes_and_specs');

	get('get-companies-by-make', 'APIController@companies_by_make');

	get('get-companies-by-make-and-spec', 'APIController@companies_by_make_and_spec');

});