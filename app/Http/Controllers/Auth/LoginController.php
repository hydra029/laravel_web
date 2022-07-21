<?php
/** @noinspection NullPointerExceptionInspection */

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
        if ($user = Employee::query()
            ->where('email', $email)
            ->first()) {
            $role_name = Role::query()->select('name')->whereId($user->role_id)->first();
            session()->put('id', $user->id);
            session()->put('name', $user->fname);
            session()->put('avatar', $user->avatar);
            session()->put('role_name', $role_name->name);
            session()->put('level', 1);
            session()->flash('noti.success', 'Sign in successfully');
            if ($user->password === null) {
                $password = Hash::make($password);
                Employee::query()
                    ->where('email', $email)
                    ->update(['password' => $password]);
                return redirect()->route('employees.index');
            }

            if (Hash::check($password, $user->password)) {
                return redirect()->route('employees.index');
            }

            if (session('remember') === 0) {
                session()->flush();
            }

            session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name','name','avatar']);
            session()->flash('noti.error', 'Wrong email or password');
            return back();
        }

        if ($user = Manager::where('email', $email)
            ->first()) {
            $role_name = Role::query()->select('name')->whereId($user->role_id)->first();
            session()->put('id', $user->id);
            session()->put('name', $user->fname);
            session()->put('avatar', $user->avatar);
            session()->put('dept_id', $user->dept_id);
            session()->put('role_name', $role_name->name);
            session()->put('level', 2);
            session()->flash('noti.success', 'Sign in successfully');
            if ($user->password === null) {
                $password = Hash::make($password);
                Manager::where('email', $email)
                    ->update(['password' => $password]);
                return redirect()->route('managers.index');
            }
            if (Hash::check($password, $user->password)) {
                return redirect()->route('managers.index');
            }
            if (session('remember') === 0) {
                session()->flush();
            }

            session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name','name','avatar']);
            session()->flash('noti.error', 'Wrong email or password');
            return back();
        }
        if ($user = Accountant::where('email', $email)
            ->first()) {
            $role_name = Role::query()->select('name')->whereId($user->role_id)->first();
            session()->put('id', $user->id);
            session()->put('name', $user->fname);
            session()->put('avatar', $user->avatar);
            session()->put('dept_id', $user->dept_id);
            session()->put('role_name', $role_name->name);
            session()->put('level', 3);
            session()->flash('noti.success', 'Sign in successfully');
            if ($user->password === null) {
                $password = Hash::make($password);
                Accountant::where('email', $email)
                    ->update(['password' => $password]);
                session()->put('level', 3);
                session()->flash('noti.success', 'Sign in successfully');
                return redirect()->route('accountants.index');
            }

            if (Hash::check($password, $user->password)) {
                return redirect()->route('accountants.index');
            }

            if (session('remember') === 0) {
                session()->flush();
            }

            session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name','name','avatar']);
            session()->flash('noti.error', 'Wrong email or password');
            return back();
        }

        if ($user = Ceo::where('email', $email)
            ->first()) {
            session()->put('id', $user->id);
            session()->put('name', $user->fname);
            session()->put('avatar', $user->avatar);
            session()->put('role_name', 'Ceo');
            session()->put('level', 4);
            session()->flash('noti.success', 'Sign in successfully');
            if ($user->password === null) {
                $password = Hash::make($password);
                Ceo::where('email', $email)
                    ->update(['password' => $password]);
                return redirect()->route('ceo.index');
            }
            if (Hash::check($password, $user->password)) {
                return redirect()->route('ceo.index');
            }
            if (session('remember') === 0) {
                session()->flush();
            }

            session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name','name','avatar']);
            session()->flash('noti.error', 'Wrong email or password');
            return back();
        }

        session()->flash('noti.error', 'Wrong email or password');
        return back();
    }

    public function logout(): RedirectResponse
    {
        if (session('remember') === 0) {
            session()->flush();
        }

        session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name','name','avatar']);
        session()->flash('noti.success', 'Log out successfully');
        return redirect()->route('login');
    }
}
