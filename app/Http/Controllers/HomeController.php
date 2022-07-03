<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Request;

class HomeController extends Controller
{

	/**
	 * Show the application dashboard.
	 *
	 * @return Renderable
	 */
	public function test(): Renderable
	{
		return view('test');
	}

	public function processLogin1(Request $request): RedirectResponse
	{
		dd($request);
		session()->put('email', $request->email);
		session()->put('password', $request->password);
		session()->put('remember', $request->checkbox-signin);
		session()->put('ad', 'a email or password');
		session()->put('aaa', 'Wrong email or password');

//		return back()->with('msg', 'The Message');
	}


}
