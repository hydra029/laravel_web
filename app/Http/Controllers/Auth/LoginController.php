<?php
/** @noinspection NullPointerExceptionInspection */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Accountant;
use App\Models\Ceo;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
	public function login()
	{
		$this->middleware('login');
		return view('auth.login');
	}

	public function processLogin(LoginRequest $request)
	{
		$email    = $request->get('email');
		$password = $request->get('password');
		session()->put('email', $email);
		session()->put('password', $password);
		session()->put('remember', 0);
		if ($request->has('checkbox_signin')) {
			session()->put('remember', 1);
		}
		if ($user = Employee::where('email', $email)
			->first()) {
			$role_name = Role::where('id', '=', $user->role_id)->first('name');
			$dept_name = Department::where('id', '=', $user->dept_id)->first('name');
			session()->put(
				[
					'id'        => $user->id,
					'name'      => $user->fname,
					'avatar'    => $user->avatar,
					'dept_id'   => $user->dept_id,
					'dept_name' => $dept_name->name,
					'role_name' => $role_name->name,
					'level'     => 1,
				]
			);
			session()->flash('noti', [
				'heading' => 'Login successfully',
				'text'    => 'You are now logged into system',
				'icon'    => 'success',
			]);
			if ($user->password === null) {
				$password = Hash::make($password);
				Employee::query()
					->where('email', $email)
					->update(['password' => $password]);
				return 0;
			}

			if (Hash::check($password, $user->password)) {
				return 0;
			}

			if (session('remember') === 0) {
				session()->flush();
			}

			session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name', 'name', 'avatar']);
			return 1;
		}

		if ($user = Manager::where('email', $email)->first()) {
			$dept_name = Department::where('id', '=', $user->dept_id)->first('name');
			session()->put(
				[
					'id'        => $user->id,
					'name'      => $user->fname,
					'avatar'    => $user->avatar,
					'dept_id'   => $user->dept_id,
					'dept_name' => $dept_name->name,
					'role_name' => 'Manager',
					'level'     => 2,
				]
			);
			session()->flash('noti', [
				'heading' => 'Login successfully',
				'text'    => 'You are now logged into system',
				'icon'    => 'success',
			]);
			if ($user->password === null) {
				$password = Hash::make($password);
				Manager::where('email', $email)
					->update(['password' => $password]);
				return 0;
			}
			if (Hash::check($password, $user->password)) {
				return 0;
			}
			if (session('remember') === 0) {
				session()->flush();
			}

			session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name', 'name', 'avatar']);
			return 1;
		}

		if ($user = Accountant::where('email', $email)->first()) {
			$role_name = Role::where('id', '=', $user->role_id)->first('name');
			session()->put(
				[
					'id'        => $user->id,
					'name'      => $user->fname,
					'avatar'    => $user->avatar,
					'dept_id'   => $user->dept_id,
					'dept_name' => 'Accountant',
					'role_name' => $role_name->name,
					'level'     => 3,
				]
			);
			session()->flash('noti', [
				'heading' => 'Login successfully',
				'text'    => 'You are now logged into system',
				'icon'    => 'success',
			]);
			if ($user->password === null) {
				$password = Hash::make($password);
				Accountant::where('email', $email)
					->update(['password' => $password]);

				return 0;
			}

			if (Hash::check($password, $user->password)) {
				return 0;
			}

			if (session('remember') === 0) {
				session()->flush();
			}

			session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name', 'name', 'avatar']);
			return 1;
		}

		if ($user = Ceo::where('email', $email)->first()) {
			session()->put(
				[
					'id'        => $user->id,
					'name'      => $user->fname,
					'avatar'    => $user->avatar,
					'role_name' => 'CEO',
					'level'     => 4,
				]
			);
			session()->flash('noti', [
				'heading' => 'Login successfully',
				'text'    => 'You are now logged into system',
				'icon'    => 'success',
			]);
			if ($user->password === null) {
				$password = Hash::make($password);
				Ceo::where('email', $email)
					->update(['password' => $password]);
				return 0;
			}
			if (Hash::check($password, $user->password)) {
				return 0;
			}
			if (session('remember') === 0) {
				session()->flush();
			}

			session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name', 'name', 'avatar']);
			return 1;
		}

		return 1;
	}

	public function logout(): RedirectResponse
	{
		if (session('remember') === 0) {
			session()->flush();
		}

		session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name', 'name', 'avatar']);
		session()->flash('noti', [
			'heading' => 'Log out successfully',
			'text'    => 'You are now logged out',
			'icon'    => 'success',
		]);
		return redirect()->route('login');
	}
}
