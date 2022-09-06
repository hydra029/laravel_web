<?php
/** @noinspection NullPointerExceptionInspection */

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Fines;
use App\Models\Manager;
use App\Models\Role;
use App\Models\Salary;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AccountantController extends Controller
{
	use ResponseTrait;

	public function __construct()
	{
		$this->middleware('accountant');
		$this->model = Manager::query();
		$routeName   = Route::currentRouteName();
		$arr         = explode('.', $routeName);
		$arr[1]      = explode('_', $arr[1]);
		$arr[1]      = array_map('ucfirst', $arr[1]);
		$arr[1]      = implode(' ', $arr[1]);
		$arr         = array_map('ucfirst', $arr);
		$title       = implode(' - ', $arr);
		View::share('title', $title);
	}

	/**
	 * Display a listing of the resource.
	 *
	 */
	public function index()
	{
		$data = AttendanceShiftTime::query()
			->get();
		return view('accountants.index', [
			'data' => $data,
		]);
	}

	public function attendanceHistory(): Renderable
	{
		return view('accountants.attendance_history');
	}

	public function historyApi(Request $request)
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
		$shift = $this->getShift($time, 'check_in');
		if ($shift === 0) {
			return 0;
		}
		Attendance::create(
			[
				'date'     => date('Y-m-d'),
				'emp_id'   => session('id'),
				'emp_role' => EmpRoleEnum::ACCOUNTANT,
				'shift'    => $shift,
				'check_in' => $time,
			],
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

	public function checkout(): int
	{
		$time  = date('H:i');
		$shift = $this->getShift($time, 'check_out');
		if ($shift === 0) {
			return 0;
		}
		Attendance::updateOrCreate(
			[
				'date'     => date('Y-m-d'),
				'emp_id'   => session('id'),
				'emp_role' => EmpRoleEnum::ACCOUNTANT,
				'shift'    => $shift,
			],
			[
				'check_out' => $time,
			]
		);
		return 1;
	}

	public function salary(): Renderable
	{
		return view('accountants.salary');
	}

	public function employeeSalary(): Renderable
	{
		return view('accountants.employee_salary');
	}

	public function departmentApi(): Collection
	{
		$acct = session('id');
		return Department::query()
			->where('acct_id', '=', $acct)
			->whereNull('deleted_at')
			->get('name');
	}

	public function getSalary(Request $request): JsonResponse
	{
		$acct      = session('id');
		$month     = $request->month;
		$year      = $request->year;
		$dept      = $request->department;
		$dept_name = Department::where('id', '=', $dept)->first('name');
		if ($dept === 'all') {
			$dept_name = Department::where('acct_id', '=', $acct)->pluck('name');
		}
		$salary = Salary::query()->with('emp')
			->where('month', $month)
			->where('year', $year)
			->whereIn('dept_name', $dept_name)
			->orderBy('dept_name')
			->paginate(20);
		$salary->append(['salary_money', 'deduction_detail', 'pay_rate_money', 'bonus_salary_total_off_work_day']);

		$arr['data']       = $salary->getCollection();
		$arr['pagination'] = $salary->linkCollection();
		return $this->successResponse($arr);
	}

	public function salaryDetail(Request $request): array
	{
		$id        = $request->id;
		$dept_name = $request->dept_name;
		$role_name = $request->role_name;
		$month     = $request->month;
		$year      = $request->year;
		$fines     = Fines::query()->get()->append('deduction_detail');
		$salary    = Salary::query()->with('emp')
			->where('emp_id', $id)
			->where('month', $month)
			->where('year', $year)
			->where('dept_name', $dept_name)
			->where('role_name', $role_name)
			->first();
		$salary->append(
			[
				'salary_money',
				'deduction_detail',
				'pay_rate_money',
				'bonus_salary_off_work_day',
				'bonus_salary_over_work_day',
				'deduction_late_one_detail',
				'deduction_late_two_detail',
				'deduction_early_one_detail',
				'deduction_early_two_detail',
				'deduction_miss_detail',
				'pay_rate_over_work_day',
				'pay_rate_off_work_day',
				'pay_rate_work_day'
			]
		)->toArray();
		$arr['salary'] = $salary;
		$arr['fines']  = $fines;
		return $arr;
	}

	/**
	 * @throws Exception
	 */
	public function test(): void
	{
		for ($i = 1; $i <= 6; $i++) {
			$emp = Employee::query()->get();
			foreach ($emp as $e) {
				$id            = $e->id;
				$dept_id       = $e->dept_id;
				$role_id       = $e->role_id;
				$dept          = Department::query()->where('id', $dept_id)->first();
				$role          = Role::query()->where('id', $role_id)->first();
				$pay_rate      = $role->pay_rate;
				$dept_name     = $dept->name;
				$role_name     = $role->name;
				$work_day      = random_int(15, 26);
				$over_work_day = random_int(0, 26);
				$late_1        = random_int(0, 26);
				$late_2        = random_int(0, 26);
				$early_1       = random_int(0, 26);
				$early_2       = random_int(0, 26);
				$miss          = random_int(0, 26);
				$deduction     = $late_1 * 15000 + $late_2 * 30000 + $early_1 * 15000 + $early_2 * 30000 + $miss * 50000;
				$salary        = (($pay_rate / 26) * $work_day + ($pay_rate / 26) * $over_work_day * 0.75) - $deduction;
				Salary::create(
					[
						'emp_id'        => $id,
						'dept_name'     => $dept_name,
						'role_name'     => $role_name,
						'month'         => $i,
						'year'          => 2022,
						'work_day'      => $work_day,
						'over_work_day' => $over_work_day,
						'pay_rate'      => $pay_rate,
						'late_one'      => $late_1,
						'late_two'      => $late_2,
						'early_one'     => $early_1,
						'early_two'     => $early_2,
						'miss'          => $miss,
						'mgr_id'        => random_int(1, 5),
						'deduction'     => $deduction,
						'salary'        => $salary,
					]
				);
			}
		}
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
					->update(['acct_id' => 1]);
			}
			return $this->successResponse(['message' => 'Sign success']);
		}
		catch (Exception $e) {
			return $this->errorResponse(['message' => $e->getMessage()]);
		}
	}
}
