<?php

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Enums\ShiftStatusEnum;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Accountant;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class EmployeeController extends Controller
{

	use ResponseTrait;

	public function __construct()
	{
		$this->middleware('employee');
		$routeName = Route::currentRouteName();
		$arr       = explode('.', $routeName);
		$arr[1]    = explode('_', $arr[1]);
		$arr[1]    = array_map('ucfirst', $arr[1]);
		$arr[1]    = implode(' ', $arr[1]);
		$arr       = array_map('ucfirst', $arr);
		$title     = implode(' - ', $arr);

		View::share('title', $title);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Application|Factory  \Contracts\View\View
	 */
	public function index()
	{
		$data = AttendanceShiftTime::query()
			->get();
		return view('employees.index', [
			'data' => $data,
		]);
	}

	public function employee_infor(Request $request)
	{
		$id = $request->get('id');
		return Employee::query()
			->where('id', '=', $id)
			->first();
	}

	public function attendance_history(): Renderable
	{
		return view('employees.attendance_history');
	}

	public function history_api(Request $request): array
	{
		$f     = $request->f;
		$l     = $request->l;
		$arr[] = AttendanceShiftTime::get();
		$arr[] = Attendance::query()
			->where('date', '<=', $l)
			->where('date', '>=', $f)
			->where('emp_id', '=', session('id'))
			->where('emp_role', '=', session('level'))
			->get();
		return $arr;
	}

	public function checkin(Request $request): RedirectResponse
	{
		Attendance::query()
			->where('emp_id', '=', session('id'))
			->where('emp_role', '=', EmpRoleEnum::EMPLOYEE)
			->where('date', '=', date('Y-m-d'))
			->where('shift', '=', $request->get('shift'))
			->update(['check_in' => date('H:i')]);
		session()->flash('noti', [
			'heading' => 'Check in successfully',
			'text'    => 'You\'ve checked in shift ' . $request->get('shift') . ' successfully',
			'icon'    => 'success',
		]);
		return redirect()->route('employees.index');
	}

	public function checkout(Request $request): RedirectResponse
	{
		Attendance::where('emp_id', '=', session('id'))
			->where('emp_role', '=', EmpRoleEnum::EMPLOYEE)
			->where('date', '=', date('Y-m-d'))
			->where('shift', '=', $request->get('shift'))
			->update(['check_out' => date('H:i')]);
		session()->flash('noti', [
			'heading' => 'Check out successfully',
			'text'    => 'You\'ve checked out shift ' . $request->get('shift') . ' successfully',
			'icon'    => 'success',
		]);
		return redirect()->route('employees.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(): Response
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StoreEmployeeRequest $request
	 * @return RedirectResponse
	 */
	public function store(StoreEmployeeRequest $request): RedirectResponse {}

	/**
	 * Display the specified resource.
	 *
	 * @param Employee $employee
	 * @return void
	 */
	public function show(Employee $employee): void
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Employee $employee
	 * @return void
	 */
	public function edit(Employee $employee): void
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdateEmployeeRequest $request
	 * @param Employee $employee
	 * @return void
	 */
	public function update(UpdateEmployeeRequest $request, Employee $employee): void {}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Employee $employee
	 * @return Response
	 */
	public function destroy(Employee $employee): Response
	{
		//
	}
}
