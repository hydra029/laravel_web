<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckLogin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure(Request): (Response|RedirectResponse)  $next
	 * @return Response|RedirectResponse
	 */
	public function handle(Request $request, Closure $next)
	{
		switch (session('level')) {
			case 1:
				return redirect()->route('employees.index');
			case 2:
				return redirect()->route('managers.index');
			case 3:
				return redirect()->route('accountants.index');
			case 4:
				return redirect()->route('ceo.index');
			default:
				return $next($request);
		}
	}
}
