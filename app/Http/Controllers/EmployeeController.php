<?php
/** @noinspection NullPointerExceptionInspection */

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
use App\Models\Employee;
use App\Models\Fines;
use App\Models\Salary;
use Exception;
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

	public function history_api(Request $request)
	{
		$first_day = $request->first_day;
		$last_day  = $request->last_day;
		return Attendance::query()
			->where('date', '<=', $last_day)
			->where('date', '>=', $first_day)
			->where('emp_id', '=', session('id'))
			->where('emp_role', '=', session('level'))
			->get();
	}

	public function checkin(): int
	{
		$time  = date('H:i');
		$shift =$this->getShift($time, 'check_in');
		if ($shift === 0) {
			return 0;
		}
		Attendance::updateOrCreate(
			[
				'date'     => date('Y-m-d'),
				'emp_id'   => session('id'),
				'emp_role' => EmpRoleEnum::EMPLOYEE,
				'shift'    => $shift,
			],
			[
				'check_in' => $time,
			]
		);
		return 1;
	}

	public function checkout(): int
	{
		$time  = date('H:i');
		$shift =$this->getShift($time, 'check_out');
		if ($shift === 0) {
			return 0;
		}
		Attendance::updateOrCreate(
			[
				'date'     => date('Y-m-d'),
				'emp_id'   => session('id'),
				'emp_role' => EmpRoleEnum::EMPLOYEE,
				'shift'    => $shift,
			],
			[
				'check_out' => $time,
			]
		);
		return 1;
	}

	public function getShift($time, $type): int
	{
		$shift1 = AttendanceShiftTime::where('id', '=', 1)->first();
		$shift2 = AttendanceShiftTime::where('id', '=', 2)->first();
		$shift3 = AttendanceShiftTime::where('id', '=', 3)->first();
		if ($type === 'check_out') {
			$first_shift_start  = $shift1->check_out_early_1;
			$second_shift_start = $shift2->check_out_early_1;
			$last_shift_start   = $shift3->check_out_early_1;
			$first_shift_end    = $shift1->check_out_end;
			$second_shift_end   = $shift2->check_out_end;
			$last_shift_end     = $shift3->check_out_end;
		} else {
			$first_shift_start  = $shift1->check_in_start;
			$second_shift_start = $shift2->check_in_start;
			$last_shift_start   = $shift3->check_in_start;
			$first_shift_end    = $shift1->check_in_late_2;
			$second_shift_end   = $shift2->check_in_late_2;
			$last_shift_end     = $shift3->check_in_late_2;
		}
		$shift = 0;
		if ($time >= $first_shift_start && $time <= $first_shift_end) {
			$shift = 1;
		}
		if ($time >= $second_shift_start && $time <= $second_shift_end) {
			$shift = 2;
		}
		if ($time >= $last_shift_start && $time <= $last_shift_end) {
			$shift = 3;
		}
		return $shift;
	}


	public function salary()
	{
		return view('employees.salary');
	}

	public function salary_detail(Request $request): array
	{
		$id            = $request->id;
		$dept_name     = $request->dept_name;
		$role_name     = $request->role_name;
		$month         = $request->month;
		$year          = $request->year;
		$fines         = Fines::query()->get()->append('deduction_detail');
		$salary        = Salary::query()->with('emp')
			->where('emp_id', $id)
			->where('month', $month)
			->where('year', $year)
			->where('dept_name', $dept_name)
			->where('role_name', $role_name)
			->where('sign', 2)
			->first()
			->append(['salary_money', 'deduction_detail', 'pay_rate_money', 'bonus_salary_over_work_day', 'deduction_late_one_detail', 'deduction_late_two_detail', 'deduction_early_one_detail', 'deduction_early_two_detail', 'deduction_miss_detail', 'pay_rate_over_work_day', 'pay_rate_work_day'])->toArray();
		$arr['salary'] = $salary;
		$arr['fines']  = $fines;
		return $arr;
	}

	public function approve(Request $request): JsonResponse
	{
		try {
			$response = $request->all();
			foreach ($response['data'] as $rq => $data) {
				$id        = $data['id'];
				$dept_name = $data['dept_name'];
				$role_name = $data['role_name'];
				$month     = $data['month'];
				$year      = $data['year'];
				Salary::query()
					->where('emp_id', $id)
					->where('dept_name', $dept_name)
					->where('role_name', $role_name)
					->where('month', $month)
					->where('year', $year)
					->update(['sign' => 3]);
			}
			return $this->successResponse([
				                              'message' => 'Sign success',
			                              ]);
		}
		catch (Exception $e) {
			return $this->errorResponse([
				                            'message' => $e->getMessage(),
			                            ]);
		}
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
