<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Accountant;
use App\Models\Ceo;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class LoginController extends Controller
{
	/*
   |--------------------------------------------------------------------------
   | Employee Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles authenticating users for the application and
   | redirecting them to your home screen. The controller uses a trait
   | to conveniently provide its functionality to your applications.
   |
   */

	public function login()
	{
		return view('auth.login');
	}

	public function processLogin(Request $request): RedirectResponse
	{

		try {

			if ($user = Employee::query()
				->where('email', $request->get('email'))
				->where('password', $request->get('password'))
				->firstOrFail()) {
				session()->put('email', $user->email);
				session()->put('fname', $user->fname);
				session()->put('level', 1);

				return redirect()->route('employees.index');

			}

			if ($user = Manager::query()
				->where('email', $request->get('email'))
				->where('password', $request->get('password'))
				->firstOrFail()) {
				session()->put('email', $user->email);
				session()->put('fname', $user->fname);
				session()->put('level', 2);

				return redirect()->route('managers.index');
			}

			if ($user = Accountant::query()
				->where('email', $request->get('email'))
				->where('password', $request->get('password'))
				->firstOrFail()) {
				session()->put('email', $user->email);
				session()->put('fname', $user->fname);
				session()->put('level', 3);

				return redirect()->route('accountants.index');
			}
			if ($user = Ceo::query()
				->where('email', $request->get('email'))
				->where('password', $request->get('password'))
				->firstOrFail()) {
				session()->put('email', $user->email);
				session()->put('fname', $user->fname);
				return redirect()->route('ceo.index');
			}
		} catch (Throwable $e) {
			return redirect()->route('login');
		}
	}

	public function logout(): RedirectResponse
	{
		session()->flush();

		return redirect()->route('login');
	}
}
