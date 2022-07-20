<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Accountant;
use App\Models\Ceo;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
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
//		$password = Hash::make($request->get('password'));
		$password = $request->get('password');
		session()->put('email', $email);
		session()->put('password', $password);
		session()->put('remember', 0);
		if ($request->has('checkbox_signin')) {
			session()->put('remember', 1);
		}
        if ($emp = Employee::query()
        ->where('email', $email)
        ->first()){
            if($emp->password == null){
                $role_name = Role::query()->select('name')->whereId($emp->role_id)->first();
                $password = Hash::make($password);
                Employee::query()
                ->where('email', $email)
                ->update(['password' => $password]);
                session()->put('id', $emp->id);
                session()->put('name', $emp->fname);
                session()->put('avatar', $emp->avatar);
                session()->put('role_name',$role_name->name);
                session()->put('level', 1);
                session()->flash('noti.success', 'Sign in successfully');
                return redirect()->route('employees.index');
            }else{
                if ( $emp && Hash::check($password, $emp->password)) {
                    $role_name = Role::query()->select('name')->whereId($emp->role_id)->first();
                            session()->put('id', $emp->id);
                            session()->put('name', $emp->fname);
                            session()->put('avatar', $emp->avatar);
                            session()->put('role_name', $role_name->name);
                            session()->put('level', 1);
                            session()->flash('noti.success', 'Sign in successfully');
                            return redirect()->route('employees.index');
                }
            }
        }

		if($mgr = Manager::query()
        ->where('email', $email)
        ->first()){
            if($mgr->password == null){
                $role_name = Role::query()->select('name')->whereId($emp->role_id)->first();
                $password = Hash::make($password);
                Manager::query()
                ->where('email', $email)
                ->update(['password' => $password]);
                session()->put('id', $mgr->id);
                session()->put('name', $mgr->fname);
                session()->put('avatar', $mgr->avatar);
                session()->put('role_name', $role_name->name);
                session()->put('level', 2);
                session()->flash('noti.success', 'Sign in successfully');
                return redirect()->route('managers.index');
            }else{

                if ($mgr && Hash::check($password, $mgr->password)) {
                    $role_name = Role::query()->select('name')->whereId($emp->role_id)->first();
                    session()->put('id', $mgr->id);
                    session()->put('name', $mgr->fname);
                    session()->put('avatar', $mgr->avatar);
                    session()->put('role_name', $role_name->name);
                    session()->put('level', 2);
                    session()->flash('noti.success', 'Sign in successfully');
                    return redirect()->route('managers.index');
                }
            }
        }
        if($acct = Accountant::query()
        ->where('email', $email)
        ->first()){
            if($acct->password == null){
                $role_name = Role::query()->select('name')->whereId($emp->role_id)->first();
                $password = Hash::make($password);
                Accountant::query()
                ->where('email', $email)
                ->update(['password' => $password]);
                session()->put('id', $acct->id);
                session()->put('name', $acct->fname);
                session()->put('avatar', $acct->avatar);
                session()->put('role_name', $role_name->name);
                session()->put('level', 3);
                session()->flash('noti.success', 'Sign in successfully');
                return redirect()->route('accountants.index');
            }else{

                if ($acct && Hash::check($password, $acct->password)) {
                    $role_name = Role::query()->select('name')->whereId($emp->role_id)->first();
                    session()->put('id', $acct->id);
                    session()->put('name', $acct->fname);
                    session()->put('avatar', $acct->avatar);
                    session()->put('role_name', $role_name->name);
                    session()->put('level', 3);
                    session()->flash('noti.success', 'Sign in successfully');
                    return redirect()->route('accountants.index');
                }
            }
        }

        if ($ceo = Ceo::query()
        ->where('email', $email)
        ->first()){
            if($ceo->password == null){
                $password = Hash::make($password);
                Ceo::query()
                ->where('email', $email)
                ->update(['password' => $password]);
                session()->put('id', $ceo->id);
                session()->put('name', $ceo->fname);
                session()->put('avatar', $ceo->avatar);
                session()->put('role_name', 'Ceo');
                session()->put('level', 4);
                session()->flash('noti.success', 'Sign in successfully');
                // $data = session()->all();
                // return $data;
                return redirect()->route('ceo.index');
            }else{
                if ($ceo && Hash::check($password, $ceo->password)) {
                    session()->put('id', $ceo->id);
                    session()->put('name', $ceo->fname);
                    session()->put('avatar', $ceo->avatar);
                    session()->put('role_name', 'Ceo');
                    session()->put('level', 4);
                    session()->flash('noti.success', 'Sign in successfully');
                    // $data = session()->all();
                    // return $data;
                    return redirect()->route('ceo.index');
                }
            }
        }


		session()->flash('noti.error', 'Wrong email or password');
		return back();
	}

	public function logout(): RedirectResponse
	{
		if (session()->missing('remember')) {
			session()->flush();
		}

		session()->forget(['id', 'level', 'noti', 'dept_id']);
		session()->flash('noti.success', 'Log out successfully');
		return redirect()->route('login');
	}
}
