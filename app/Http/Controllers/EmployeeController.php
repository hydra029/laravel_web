<?php
/** @noinspection NullPointerExceptionInspection */

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Enums\ShiftStatusEnum;
use App\Http\Requests\AttendanceRequest;
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

	public function checkin(AttendanceRequest $request): int
	{
		$time        = date('H:i');
		$shift1      = AttendanceShiftTime::where('id', '=', 1)->first();
		$shift2      = AttendanceShiftTime::where('id', '=', 2)->first();
		$shift3      = AttendanceShiftTime::where('id', '=', 3)->first();
		$in_start_1  = $shift1->check_in_start;
		$in_start_2  = $shift2->check_in_start;
		$in_start_3  = $shift3->check_in_start;
		$in_end_1    = $shift1->check_in_late_2;
		$in_end_2    = $shift2->check_in_late_2;
		$in_end_3    = $shift3->check_in_late_2;
		$shift       = 0;
		$attendance  = Attendance::query()
			->where('emp_id', '=', session('id'))
			->where('emp_role', '=', EmpRoleEnum::EMPLOYEE)
			->where('date', '=', date('Y-m-d'))
			->where('shift', '=', $shift)
			->first();
		if ($time >= $in_start_1 && $time <= $in_end_1) {
			$shift = 1;
		}
		if ($time >= $in_start_2 && $time <= $in_end_2) {
			$shift = 2;
		}
		if ($time >= $in_start_3 && $time <= $in_end_3) {
			$shift = 3;
		}
		if ($attendance) {
			Attendance::query()
				->where('emp_id', '=', session('id'))
				->where('emp_role', '=', EmpRoleEnum::EMPLOYEE)
				->where('date', '=', date('Y-m-d'))
				->where('shift', '=', $shift)
				->update(['check_in' => $time]);
		} else {
			Attendance::query()
				->insert(
					[
						'date'     => date('Y-m-d'),
						'emp_id'   => session('id'),
						'emp_role' => EmpRoleEnum::EMPLOYEE,
						'shift'    => $shift,
						'check_in' => $time,
					]
				);
		}
		session()->flash('noti', [
			'heading' => 'Check in successfully',
			'text'    => 'You\'ve checked in successfully',
			'icon'    => 'success',
		]);
		return 1;
	}

	public function checkout(AttendanceRequest $request): int
	{
		$time        = date('H:i');
		$shift1      = AttendanceShiftTime::where('id', '=', 1)->first();
		$shift2      = AttendanceShiftTime::where('id', '=', 2)->first();
		$shift3      = AttendanceShiftTime::where('id', '=', 3)->first();
		$out_start_1 = $shift1->check_out_early_1;
		$out_start_2 = $shift2->check_out_early_1;
		$out_start_3 = $shift3->check_out_early_1;
		$out_end_1   = $shift1->check_out_end;
		$out_end_2   = $shift2->check_out_end;
		$out_end_3   = $shift3->check_out_end;
		$shift       = 0;
		$attendance  = Attendance::query()
			->where('emp_id', '=', session('id'))
			->where('emp_role', '=', EmpRoleEnum::EMPLOYEE)
			->where('date', '=', date('Y-m-d'))
			->where('shift', '=', $shift)
			->first();
		if ($time >= $out_start_1 && $time <= $out_end_1) {
			$shift = 1;
		}
		if ($time >= $out_start_2 && $time <= $out_end_2) {
			$shift = 2;
		}
		if ($time >= $out_start_3 && $time <= $out_end_3) {
			$shift = 3;
		}
		if ($attendance) {
			Attendance::query()
				->where('emp_id', '=', session('id'))
				->where('emp_role', '=', EmpRoleEnum::EMPLOYEE)
				->where('date', '=', date('Y-m-d'))
				->where('shift', '=', $shift)
				->update(['check_out' => $time]);
		} else {
			Attendance::query()
				->insert(
					[
						'date'     => date('Y-m-d'),
						'emp_id'   => session('id'),
						'emp_role' => EmpRoleEnum::EMPLOYEE,
						'shift'    => $shift,
						'check_out' => $time,
					]
				);
		}
		session()->flash('noti', [
			'heading' => 'Check out successfully',
			'text'    => 'You\'ve checked out successfully',
			'icon'    => 'success',
		]);
		return 1;
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
