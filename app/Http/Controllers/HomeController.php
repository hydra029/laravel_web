<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Symfony\Component\HttpFoundation\Cookie;

class HomeController extends Controller
{

	/**
	 * Show the application dashboard.
	 *
	 * @return Renderable
	 */
	public function test(): Renderable
	{
		return view('test',([
			'title' => 'Test'
		]));
	}
}
