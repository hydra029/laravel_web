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

	public function processLogin(Request $request)
	{
		$email = $request->get('email');
		$password = $request->get('password');
		session()->put('email', $email);
		session()->put('password', $password);
		session()->put('remember', 0);
		if ($request->has('checkbox_signin')) {
			session()->put('remember', 1);
		}

		if ($user = Employee::query()
			->where('email', $email)
			->where('password', $password)
			->first()) {
			session()->put('id', $user->id);
			session()->put('name', $user->fname);
			session()->put('avatar', $user->avatar);
			session()->put('dept_id', $user->dept_id);
			session()->put('level', 1);
			session()->flash('noti.success', 'Sign in successfully');
			return redirect()->route('employees.index');
		}

		if ($user = Manager::query()
			->where('email', $email)
			->where('password', $password)
			->first()) {
			session()->put('id', $user->id);
			session()->put('name', $user->fname);
			session()->put('avatar', $user->avatar);
			session()->put('dept_id', $user->dept_id);
			session()->put('level', 2);
			session()->flash('noti.success', 'Sign in successfully');
			return redirect()->route('managers.index');
		}

		if ($user = Accountant::query()
			->where('email', $email)
			->where('password', $password)
			->first()) {
			session()->put('id', $user->id);
			session()->put('name', $user->fname);
			session()->put('avatar', $user->avatar);
			session()->put('dept_id', $user->dept_id);
			session()->put('level', 3);
			session()->flash('noti.success', 'Sign in successfully');
			return redirect()->route('accountants.index');
		}

		if ($user = Ceo::query()
			->where('email', $email)
			->where('password', $password)
			->first()) {
			session()->put('id', $user->id);
			session()->put('name', $user->fname);
			session()->put('avatar', $user->avatar);
			session()->put('level', 4);
			session()->flash('noti.success', 'Sign in successfully');
            // $data = session()->all();
            // return $data;
			return redirect()->route('ceo.index');
		}
		session()->flash('noti.error', 'Wrong email or password');
		return back();
	}

	public function logout(): RedirectResponse
	{
		if (session()->missing('remember')) {
			session()->flush();
		}
		session()->forget(['id', 'level', 'noti']);
		session()->flash('noti.success', 'Log out successfully');

		return redirect()->route('login');
	}
}
