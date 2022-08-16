<?php
/** @noinspection NullPointerExceptionInspection */

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Enums\ShiftEnum;
use App\Http\Requests\AssignRequest;
use App\Http\Requests\AttendanceRequest;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use App\Models\Accountant;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Fines;
use App\Models\Manager;
use App\Models\Role;
use App\Models\Salary;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class ManagerController extends Controller
{
	use ResponseTrait;

	public function __construct()
	{
		$this->middleware('manager');
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

	public function index()
	{
		$data = AttendanceShiftTime::query()
			->get();
		return view('managers.index', [
			'data' => $data,
		]);
	}

	public function add(): RedirectResponse {}

	public function today_attendance()
	{
		$limit   = 10;
		$date    = date('Y-m-d');
		$dept_id = session('dept_id');
		$data    = Employee::with([
			'attendance' => function ($query) use ($date) {
				$query->where('date', '=', $date);
			}, 'roles'
		])
			->where('dept_id', '=', $dept_id)
			->whereNull('deleted_at')
			->paginate($limit);
		$shifts  = ShiftEnum::getArrayView();
		return view('managers.today_attendance', [
			'data'   => $data,
			'num'    => 1,
			'shifts' => $shifts,
		]);
	}

	public function attendance_history()
	{
		return view('managers.attendance_history');
	}

	public function employee_attendance(): Renderable
	{
		return view('managers.employee_attendance');
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

	public function attendance_api(Request $request): array
	{
		$dept_id = session('dept_id');
		$s       = $request->s;
		$m       = $request->m;
		$data[]  = AttendanceShiftTime::get();
		if ($dept_id === 1) {
			$data[] = Manager::with(
				[
					'attendance' => function ($query) use ($s, $m) {
						$query->where('date', '<=', $s)->where('date', '>=', $m);
					},
					'departments',
					'roles',
				]
			)
				->whereNull('deleted_at')
				->whereDeptId($dept_id)
				->get(['id', 'lname', 'fname', 'dept_id', 'role_id']);
			$data[] = Accountant::with(
				[
					'attendance' => function ($query) use ($s, $m) {
						$query->where('date', '<=', $s)->where('date', '>=', $m);
					},
					'departments',
					'roles',
				]
			)
				->whereNull('deleted_at')
				->get(['id', 'lname', 'fname', 'dept_id', 'role_id']);
		} else {
			$data[] = Manager::with(
				[
					'attendance' => function ($query) use ($s, $m) {
						$query->where('date', '<=', $s)->where('date', '>=', $m);
					},
					'departments',
					'roles',
				]
			)
				->whereNull('deleted_at')
				->whereDeptId($dept_id)
				->get(['id', 'lname', 'fname', 'dept_id', 'role_id']);
			$data[] = Employee::with(
				[
					'attendance' => function ($query) use ($s, $m) {
						$query->where('date', '<=', $s)->where('date', '>=', $m);
					},
					'departments',
					'roles',
				]
			)
				->whereNull('deleted_at')
				->whereDeptId($dept_id)
				->get(['id', 'lname', 'fname', 'dept_id', 'role_id']);
		}
		return $data;
	}

	public function emp_attendance_api(Request $request): array
	{
		$emp_id   = $request->get('id');
		$dept     = $request->get('dept');
		$role     = $request->get('role');
		$month    = date('m', strtotime('last month'));
		$year     = date('Y', strtotime('last month'));
		$data[]   = Salary::query()
			->where('dept_name', '=', $dept)
			->where('role_name', '=', $role)
			->where('emp_id', '=', $emp_id)
			->where('month', '=', $month)
			->where('year', '=', $year)
			->first();
		$date     = $request->get('date');
		$emp_role = $request->get('emp_role');
		$data[]   = Attendance::query()
			->where('date', 'like', "%$date%")
			->where('emp_role', '=', $emp_role)
			->where('emp_id', '=', $emp_id)
			->get();
		return $data;
	}

	public function checkin(AttendanceRequest $request): int
	{
		$time       = date('H:i');
		$shift1     = AttendanceShiftTime::where('id', '=', 1)->first();
		$shift2     = AttendanceShiftTime::where('id', '=', 2)->first();
		$shift3     = AttendanceShiftTime::where('id', '=', 3)->first();
		$in_start_1 = $shift1->check_in_start;
		$in_start_2 = $shift2->check_in_start;
		$in_start_3 = $shift3->check_in_start;
		$in_end_1   = $shift1->check_in_late_2;
		$in_end_2   = $shift2->check_in_late_2;
		$in_end_3   = $shift3->check_in_late_2;
		$shift      = 0;
		if ($time >= $in_start_1 && $time <= $in_end_1) {
			$shift = 1;
		}
		if ($time >= $in_start_2 && $time <= $in_end_2) {
			$shift = 2;
		}
		if ($time >= $in_start_3 && $time <= $in_end_3) {
			$shift = 3;
		}
		$attendance = Attendance::query()
			->where('emp_id', '=', session('id'))
			->where('emp_role', '=', EmpRoleEnum::MANAGER)
			->where('date', '=', date('Y-m-d'))
			->where('shift', '=', $shift)
			->first();
		if ($attendance === null) {
			Attendance::query()
				->insert(
					[
						'date'      => date('Y-m-d'),
						'emp_id'    => session('id'),
						'emp_role'  => EmpRoleEnum::MANAGER,
						'shift'     => $shift,
						'check_out' => $time,
					]
				);
		} else {
			Attendance::query()
				->where('emp_id', '=', session('id'))
				->where('emp_role', '=', EmpRoleEnum::MANAGER)
				->where('date', '=', date('Y-m-d'))
				->where('shift', '=', $shift)
				->update(['check_out' => $time]);
		}
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
		if ($time >= $out_start_1 && $time <= $out_end_1) {
			$shift = 1;
		}
		if ($time >= $out_start_2 && $time <= $out_end_2) {
			$shift = 2;
		}
		if ($time >= $out_start_3 && $time <= $out_end_3) {
			$shift = 3;
		}
		$attendance = Attendance::query()
			->where('emp_id', '=', session('id'))
			->where('emp_role', '=', EmpRoleEnum::MANAGER)
			->where('date', '=', date('Y-m-d'))
			->where('shift', '=', $shift)
			->first();
		if ($attendance === null) {
			Attendance::query()
				->insert(
					[
						'date'      => date('Y-m-d'),
						'emp_id'    => session('id'),
						'emp_role'  => EmpRoleEnum::MANAGER,
						'shift'     => $shift,
						'check_out' => $time,
					]
				);
		} else {
			Attendance::query()
				->where('emp_id', '=', session('id'))
				->where('emp_role', '=', EmpRoleEnum::MANAGER)
				->where('date', '=', date('Y-m-d'))
				->where('shift', '=', $shift)
				->update(['check_out' => $time]);
		}
		return 1;
	}

	public function salary_api(Request $request): void
	{
		$role_id       = $request->get('role_id');
		$miss          = $request->get('miss');
		$E1            = $request->get('early_1');
		$E2            = $request->get('early_2');
		$L1            = $request->get('late_1');
		$L2            = $request->get('late_2');
		$over_work_day = $request->get('over_work_day');
		$work_day      = $request->get('work_day');
		$mgr_id        = session('id');
		$pay_rate      = 0;
		$pay_rates     = Role::query()
			->whereNull('deleted_at')
			->where('id', '=', $role_id)
			->first('pay_rate');
		if ($pay_rates) {
			$pay_rate = $pay_rates['pay_rate'];
		}
		$fines     = Fines::pluck('deduction', 'type');
		$fine_E1   = $fines['E1'];
		$fine_E2   = $fines['E2'];
		$fine_L1   = $fines['L1'];
		$fine_L2   = $fines['L2'];
		$fine_MS   = $fines['MS'];
		$deduction = $E1 * $fine_E1 + $E2 * $fine_E2 + $L1 * $fine_L1 + $L2 * $fine_L2 + $miss * $fine_MS;

		$salary    = ($work_day + $over_work_day) * $pay_rate / 26 - $deduction;
		$data      = new Salary;
		$data->fill($request->except('role_id'));
		$data->deduction = $deduction;
		$data->salary    = $salary;
		$data->mgr_id    = $mgr_id;
		$data->pay_rate  = $pay_rate;
		$data->save();
//		return [$emp_id, $role_name, $dept_name, $work_day, number_format($pay_rate), number_format($deduction), $E1, $E2, $L1, $L2, $miss, number_format((int)$salary)];

	}

	public function salary()
	{
		return view('managers.salary');
	}

	public function get_salary(Request $request): JsonResponse
    {	
		$dept_id = $request->dept_id;
        $month = $request->month;
        $year = $request->year;

		$dept = Department::query()->where('id', '=', $dept_id)->first();
		// dd($dept->toArray());
        $salary = Salary::query()->with('emp')
		->where('dept_name', $dept->name)
        ->where('month', $month)
        ->where('year', $year)
        ->paginate(20);
		$salary
        ->append(['salary_money','deduction_detail','pay_rate_money','bonus_salary_over_work_day']);
		
        $arr['data'] = $salary->getCollection();
        $arr['pagination'] = $salary->linkCollection();
        return $this->successResponse($arr);
    }
	
    public function salary_detail(Request $request)
    {
        $id = $request->id;
        $dept_name = $request->dept_name;
        $role_name = $request->role_name;
        $month = $request->month;
        $year = $request->year;
        $fines = Fines::query()->get()->append('deduction_detail');
        $salary = Salary::query()->with('emp')
        ->where('emp_id', $id)
        ->where('month', $month)
        ->where('year', $year)
        ->where('dept_name', $dept_name)
        ->where('role_name', $role_name)
        ->first()
        ->append(['salary_money','deduction_detail','pay_rate_money','bonus_salary_over_work_day','deduction_late_one_detail','deduction_late_two_detail','deduction_early_one_detail','deduction_early_two_detail','deduction_miss_detail','pay_rate_over_work_day','pay_rate_work_day'])->toArray();
        $arr['salary'] = $salary;
        $arr['fines'] = $fines;
        return $arr;

	public function assignment()
	{
		$data = Department::whereNull('deleted_at')
			->get(['id', 'name', 'acct_id']);
		return view(
			'managers.assignment',
			[
				'data' => $data,
			]
		);
	}

	public function accountant_api()
	{
		return Accountant::whereNull('deleted_at')
			->get(['id', 'fname', 'lname']);
	}

	public function assign_accountant(AssignRequest $request): int
	{
		$dept_id = $request->dept_id;
		$acct_id = $request->acct_id;
		if ($acct_id === '0') {
			Department::whereNull('deleted_at')
				->where('id', '=', $dept_id)
				->update(['acct_id' => null]);
			return 0;
		}
		$acc     = Accountant::whereNull('deleted_at')
			->where('id', '=', $acct_id)
			->first();
		if ($acc !== null) {
			Department::whereNull('deleted_at')
				->where('id', '=', $dept_id)
				->update(['acct_id' => $acct_id]);
			return 0;
		}
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
	 * @param StoreManagerRequest $request
	 * @return Response
	 */
	public function store(StoreManagerRequest $request): Response
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Manager $manager
	 * @return Response
	 */
	public function show(Manager $manager): Response
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Manager $manager
	 * @return Response
	 */
	public function edit(Manager $manager): Response
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdateManagerRequest $request
	 * @param Manager $manager
	 * @return Response
	 */
	public function update(UpdateManagerRequest $request, Manager $manager): Response
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Manager $manager
	 * @return Response
	 */
	public function destroy(Manager $manager): Response
	{
		//
	}
}
