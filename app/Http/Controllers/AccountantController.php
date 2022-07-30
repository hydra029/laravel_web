<?php

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Models\Accountant;
use App\Http\Requests\StoreAccountantRequest;
use App\Http\Requests\UpdateAccountantRequest;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AccountantController extends Controller
{
	public function __construct()
	{
		$this->middleware('accountant');
		$this->model = Manager::query();
		$routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $arr[1] = explode('_', $arr[1]);
        $arr[1] = array_map('ucfirst', $arr[1]);
        $arr[1] = implode(' ', $arr[1]);
        $arr = array_map('ucfirst', $arr);
        $title = implode(' - ', $arr);

		View::share('title', $title);
	}

	/**
	 * Display a listing of the resource.
	 *
	 */
	public function index()
	{
        $date = date('Y-m-d');
        $data = Attendance::with('shifts')
            ->where('emp_id', '=', session('id'))
            ->where('date', '=', $date)
            ->where('emp_role', '=', session('level'))
            ->get();
        return view('accountants.index', [
            'data' => $data,
        ]);
	}

	public function salary(): Renderable
	{
		return view('accountants.salary');
	}

	public function attendance_history(): Renderable
	{
		return view('accountants.attendance_history');
	}

    public function attendance_api(Request $request)
    {
        $f = $request->f;
        $l = $request->l;
        return Attendance::with('shifts')
            ->where('date', '<=', $l)
            ->where('date', '>=', $f)
            ->where('emp_id', '=', session('id'))
            ->where('emp_role', '=', session('level'))
            ->get();
    }

    public function checkin(Request $request): RedirectResponse
    {
        Attendance::where('emp_id', '=', session('id'))
            ->where('emp_role', '=', EmpRoleEnum::ACCOUNTANT)
            ->where('date','=', date('Y-m-d'))
            ->where('shift','=', $request->get('shift'))
            ->update(['check_in' => date('H:i')]);
        session()->flash('noti', [
            'heading' => 'Check in successfully',
            'text' => 'You\'ve checked in shift ' . $request->get('shift') . ' successfully',
            'icon' => 'success',
        ]);

        return redirect()->route('accountants.index');
    }

    public function checkout(Request $request): RedirectResponse
    {
        Attendance::where('emp_id', '=', session('id'))
            ->where('emp_role', '=', EmpRoleEnum::ACCOUNTANT)
            ->where('date','=', date('Y-m-d'))
            ->where('shift','=', $request->get('shift'))
            ->update(['check_out' => date('H:i')]);
        session()->flash('noti', [
            'heading' => 'Check out successfully',
            'text' => 'You\'ve checked out shift ' . $request->get('shift') . ' successfully',
            'icon' => 'success',
        ]);

        return redirect()->route('accountants.index');
    }
	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAccountantRequest $request
     * @return Response
     */
    public function store(StoreAccountantRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Accountant $accountant
     * @return Response
     */
    public function show(Accountant $accountant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Accountant $accountant
     * @return Response
     */
    public function edit(Accountant $accountant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAccountantRequest $request
     * @param Accountant $accountant
     * @return Response
     */
    public function update(UpdateAccountantRequest $request, Accountant $accountant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Accountant $accountant
     * @return Response
     */
    public function destroy(Accountant $accountant)
    {
        //
    }
}
