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
		$email = $request->get('email');
		$password = $request->get('password');
		session()->put('email', $email);
		session()->put('password', $password);
		session()->put('remember', 0);
		if ($request->has('checkbox_signin')) {
			session()->put('remember', 1);
		}

		if ($emp = Employee::query()
			->where('email', $email)
			->where('password', $password)
			->first()) {
			session()->put('id', $emp->id);
			session()->put('level', 1);
			session()->flash('noti.success', 'Sign in successfully');
			return redirect()->route('employees.index');
		}

		if ($mgr = Manager::query()
			->where('email', $email)
			->where('password', $password)
			->first()) {
			session()->put('id', $mgr->id);
			session()->put('level', 2);
			session()->flash('noti.success', 'Sign in successfully');
			return redirect()->route('managers.index');
		}

		if ($user = Accountant::query()
			->where('email', $email)
			->where('password', $password)
			->first()) {
			session()->put('id', $user->id);
			session()->put('level', 3);
			session()->flash('noti.success', 'Sign in successfully');
			return redirect()->route('accountants.index');
		}

		if ($user = Ceo::query()
			->where('email', $email)
			->where('password', $password)
			->first()) {
			session()->put('id', $user->id);
			session()->put('level', 4);
			session()->flash('noti.success', 'Sign in successfully');
			return redirect()->route('ceo.index');
		}
		return back()->with('noti.error', 'Wrong password or email');
	}

	public function logout(): RedirectResponse
	{
		if (session('remember') !== 1) {
			session()->flush();
		}
		session()->forget(['id', 'level',]);
		session()->flash('success', 'Log out successfully');

		return redirect()->route('login');
	}
}
