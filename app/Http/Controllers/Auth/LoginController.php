<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Accountant;
use App\Models\Ceo;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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
	public function __construct()
	{

	}


	public function login()
	{
		$this->middleware('login');
		return view('auth.login');
	}

	public function processLogin(Request $request): RedirectResponse
	{
		try {

			if ($emp = Employee::query()
				->where('email', $request->get('email'))
				->where('password', $request->get('password'))
				->first()) {
				session()->put('id', $emp->id);
				session()->put('email', $emp->email);
				session()->put('password', $emp->password);
				session()->put('level', 1);
				session()->put('success', 'Sign in successfully');
				return redirect()->route('employees.index');
			}

			if ($mgr = Manager::query()
				->where('email', $request->get('email'))
				->where('password', $request->get('password'))
				->first()) {
				session()->put('id', $mgr->id);
				session()->put('email', $mgr->email);
				session()->put('password', $mgr->password);
				session()->put('level', 2);
				session()->put('success', 'Sign in successfully');
				return redirect()->route('managers.index');
			}
			if ($user = Accountant::query()
				->where('email', $request->get('email'))
				->where('password', $request->get('password'))
				->first()) {
				session()->put('id', $user->id);
				session()->put('email', $user->email);
				session()->put('password', $user->password);
				session()->put('level', 3);
				session()->put('success', 'Sign in successfully');
				return redirect()->route('accountants.index');
			}

			if ($user = Ceo::query()
				->where('email', $request->get('email'))
				->where('password', $request->get('password'))
				->first()) {
				session()->put('id', $user->id);
				session()->put('email', $user->email);
				session()->put('password', $user->password);
				session()->put('level', 4);
				session()->put('success', 'Sign in successfully');
				return redirect()->route('ceo.index');
			}
			session()->put('level',0);
			session()->put('error', 'Wrong email or password');
			return redirect()->route('login');
		} catch (Throwable $e) {
			return back();
		}
	}

	public function logout(): RedirectResponse
	{
		session()->flush();

		return redirect()->route('login');
	}
}
