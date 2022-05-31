<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckCeo
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
		if (!session('key')) {
			return redirect()->route('login');
		}
		switch (session('key')) {
			case 1:
				return redirect()->route('employee.index');
			case 2:
				return redirect()->route('manager.index');
			case 3:
				return redirect()->route('accountant.index');
			default:
				return $next($request);
		}
	}
}
