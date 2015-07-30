<?php namespace App;

class Singleton {

	private static $types;

	private static $specs;

	private static $requestsCount;

	private static $responsesCount;

	public static function types() {

		if(self::$types)
			return self::$types;
		else {
			self::$types = \App\Type::all();
			return self::$types;
		}

	}

	public static function specs() {

		if(self::$specs)
			return self::$specs;
		else {
			self::$specs = \App\Spec::all();
			return self::$specs;
		}

	}
	
	public static function requestsCount() {

		if(is_null(self::$requestsCount) && \Auth::check())
			self::$requestsCount = \Auth::user()->company->requests()->wherePivot('read', 0)->count();

		return self::$requestsCount;

	}	

	public static function responsesCount() {

		if(is_null(self::$responsesCount) && \Auth::check())
			self::$responsesCount = \Auth::user()->responsesCount();

		return self::$responsesCount;

	}

	public static function set($name, $value) {
		self::$$name = $value;
	}

}