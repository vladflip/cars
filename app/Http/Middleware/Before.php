<?php namespace App\Http\Middleware;

use Closure;
use Auth;

class Before {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		
		$this->updateCompanyRequests();

		return $next($request);

	}

	public function updateCompanyRequests() {

		if( Auth::check() ) {

			if( Auth::user()->company ) {

				Auth::user()->company->updateRequests();

			}

		}

	}

}
