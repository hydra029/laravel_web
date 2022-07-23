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
            session()->put([
                'id' => $user->id,
                'name' => $user->fname,
                'avatar' => $user->avatar,
                'dept_id' => $user->dept_id,
                'role_name' => $role_name->name,
                'level' => 1,
            ]);
            session()->flash('noti', [
                'heading' => 'Login successfully',
                'text' => 'You are now logged into system',
                'icon' => 'success',
            ]);
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

            session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name', 'name', 'avatar']);
            session()->flash('noti', [
                'heading' => 'Wrong information',
                'text' => 'Your email or password is incorrect. Please try again.',
                'icon' => 'error',
            ]);
            return back();
        }

        if ($user = Manager::where('email', $email)
            ->first()) {
            $role_name = Role::query()->select('name')->whereId($user->role_id)->first();
            session()->put([
                'id' => $user->id,
                'name' => $user->fname,
                'avatar' => $user->avatar,
                'dept_id' => $user->dept_id,
                'role_name' => $role_name->name,
                'level' => 2,
            ]);
            session()->flash('noti', [
                'heading' => 'Login successfully',
                'text' => 'You are now logged into system',
                'icon' => 'success',
            ]);
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

            session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name', 'name', 'avatar']);
            session()->flash('noti', [
                'heading' => 'Wrong information',
                'text' => 'Your email or password is incorrect. Please try again.',
                'icon' => 'error',
            ]);
            return back();
        }

        if ($user = Accountant::where('email', $email)
            ->first()) {
            session()->put([
                'id' => $user->id,
                'name' => $user->fname,
                'avatar' => $user->avatar,
                'dept_id' => $user->dept_id,
                'role_name' => 'Accountant',
                'level' => 3,
            ]);
            session()->flash('noti', [
                'heading' => 'Login successfully',
                'text' => 'You are now logged into system',
                'icon' => 'success',
            ]);
            if ($user->password === null) {
                $password = Hash::make($password);
                Accountant::where('email', $email)
                    ->update(['password' => $password]);

                return redirect()->route('accountants.index');
            }

            if (Hash::check($password, $user->password)) {
                return redirect()->route('accountants.index');
            }

            if (session('remember') === 0) {
                session()->flush();
            }

            session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name', 'name', 'avatar']);
            session()->flash('noti', [
                'heading' => 'Wrong information',
                'text' => 'Your email or password is incorrect. Please try again.',
                'icon' => 'error',
            ]);
            return back();
        }

        if ($user = Ceo::where('email', $email)
            ->first()) {
            session()->put([
                'id' => $user->id,
                'name' => $user->fname,
                'avatar' => $user->avatar,
                'dept_id' => $user->dept_id,
                'role_name' => 'CEO',
                'level' => 4,
            ]);
            session()->flash('noti', [
                'heading' => 'Login successfully',
                'text' => 'You are now logged into system',
                'icon' => 'success',
            ]);
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

            session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name', 'name', 'avatar']);
            session()->flash('noti', [
                'heading' => 'Wrong information',
                'text' => 'Your email or password is incorrect. Please try again.',
                'icon' => 'error',
            ]);
            return back();
        }

        session()->flash('noti', [
            'heading' => 'Wrong information',
            'text' => 'Your email or password is incorrect. Please try again.',
            'icon' => 'error',
        ]);
        return back();
    }

    public function logout(): RedirectResponse
    {
        if (session('remember') === 0) {
            session()->flush();
        }

        session()->forget(['id', 'level', 'noti', 'dept_id', 'role_name', 'name', 'avatar']);
        session()->flash('noti', [
            'heading' => 'Log out successfully',
            'text' => 'You are now logged out',
            'icon' => 'success',
        ]);
        return redirect()->route('login');
    }
}
