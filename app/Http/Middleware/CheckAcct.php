<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckAcct
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
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
				return $next($request);
			case 4:
				return redirect()->route('ceo.index');
			default:
				return redirect()->route('login');
		}
	}
}
