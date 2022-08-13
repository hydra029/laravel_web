<?php

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Enums\ShiftEnum;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class ManagerController extends Controller
{

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
		$date = date('Y-m-d');
		$data = Attendance::with('shifts')
			->where('emp_id', '=', session('id'))
			->where('date', '=', $date)
			->where('emp_role', '=', session('level'))
			->get();
		return view('managers.index', [
			'data' => $data,
		]);
	}

	//    public function add(): RedirectResponse
	//    {
	//        $data = [];
	//        $shift_11 = [];
	//        $shift_12 = [];
	//        $shift_21 = [];
	//        $shift_22 = [];
	//        $shift_31 = [];
	//        $shift_32 = [];
	//
	//        for ($i = 0; $i <= 59; $i++) {
	//            if ($i < 10) {
	//                $a = '0' . $i;
	//            } else {
	//                $a = $i;
	//            }
	//            $shift11 = '07:' . $a;
	//            $shift12 = '11:' . $a;
	//            $shift32 = '21:' . $a;
	//            $shift_11[] = $shift11;
	//            $shift_12[] = $shift12;
	//            $shift_32[] = $shift32;
	//        }
	//        for ($i = 31; $i <= 59; $i++) {
	//            $shift21 = '13:' . $a;
	//            $shift22 = '17:' . $a;
	//            $shift31 = '17:' . $a;
	//            $shift_21[] = $shift21;
	//            $shift_22[] = $shift22;
	//            $shift_31[] = $shift31;
	//        }
	//        for ($i = 0; $i <= 30; $i++) {
	//            if ($i < 10) {
	//                $a = '0' . $i;
	//            } else {
	//                $a = $i;
	//            }
	//            $shift21 = '14:' . $a;
	//            $shift22 = '18:' . $a;
	//            $shift31 = '18:' . $a;
	//            $shift_21[] = $shift21;
	//            $shift_22[] = $shift22;
	//            $shift_31[] = $shift31;
	//        }
	//        for ($i = 1; $i <= 30; $i++) {
	//            if ($i < 10) {
	//                $a = '0' . $i;
	//            } else {
	//                $a = $i;
	//            }
	//            $date = '2022-07-' . $a;
	//
	//            for ($j = 1; $j <= 40; $j++) {
	//                $start1 = $shift_11[array_rand($shift_11)];
	//                $end1 = $shift_12[array_rand($shift_12)];
	//                $start2 = $shift_21[array_rand($shift_21)];
	//                $end2 = $shift_22[array_rand($shift_22)];
	//                $start3 = $shift_31[array_rand($shift_31)];
	//                $end3 = $shift_32[array_rand($shift_32)];
	//                $data[] = [
	//                    'date' => $date,
	//                    'emp_id' => $j,
	//                    'emp_role' => 1,
	//                    'shift' => 1,
	//                    'check_in' => $start1,
	//                    'check_out' => $end1,
	//                ];
	//                $data[] = [
	//                    'date' => $date,
	//                    'emp_id' => $j,
	//                    'emp_role' => 1,
	//                    'shift' => 2,
	//                    'check_in' => $start2,
	//                    'check_out' => $end2,
	//                ];
	//                $data[] = [
	//                    'date' => $date,
	//                    'emp_id' => $j,
	//                    'emp_role' => 1,
	//                    'shift' => 3,
	//                    'check_in' => $start3,
	//                    'check_out' => $end3,
	//                ];
	//            }
	//            for ($j = 1; $j <= 5; $j++) {
	//                $start1 = $shift_11[array_rand($shift_11)];
	//                $end1 = $shift_12[array_rand($shift_12)];
	//                $start2 = $shift_21[array_rand($shift_21)];
	//                $end2 = $shift_22[array_rand($shift_22)];
	//                $start3 = $shift_31[array_rand($shift_31)];
	//                $end3 = $shift_32[array_rand($shift_32)];
	//                $data[] = [
	//                    'date' => $date,
	//                    'emp_id' => $j,
	//                    'emp_role' => 2,
	//                    'shift' => 1,
	//                    'check_in' => $start1,
	//                    'check_out' => $end1,
	//                ];
	//                $data[] = [
	//                    'date' => $date,
	//                    'emp_id' => $j,
	//                    'emp_role' => 2,
	//                    'shift' => 2,
	//                    'check_in' => $start2,
	//                    'check_out' => $end2,
	//                ];
	//                $data[] = [
	//                    'date' => $date,
	//                    'emp_id' => $j,
	//                    'emp_role' => 2,
	//                    'shift' => 3,
	//                    'check_in' => $start3,
	//                    'check_out' => $end3,
	//                ];
	//            }
	//            for ($j = 1; $j <= 5; $j++) {
	//                $start1 = $shift_11[array_rand($shift_11)];
	//                $end1 = $shift_12[array_rand($shift_12)];
	//                $start2 = $shift_21[array_rand($shift_21)];
	//                $end2 = $shift_22[array_rand($shift_22)];
	//                $start3 = $shift_31[array_rand($shift_31)];
	//                $end3 = $shift_32[array_rand($shift_32)];
	//                $data[] = [
	//                    'date' => $date,
	//                    'emp_id' => $j,
	//                    'emp_role' => 3,
	//                    'shift' => 1,
	//                    'check_in' => $start1,
	//                    'check_out' => $end1,
	//                ];
	//                $data[] = [
	//                    'date' => $date,
	//                    'emp_id' => $j,
	//                    'emp_role' => 3,
	//                    'shift' => 2,
	//                    'check_in' => $start2,
	//                    'check_out' => $end2,
	//                ];
	//                $data[] = [
	//                    'date' => $date,
	//                    'emp_id' => $j,
	//                    'emp_role' => 3,
	//                    'shift' => 3,
	//                    'check_in' => $start3,
	//                    'check_out' => $end3,
	//                ];
	//            }
	//        }
	//        dd($data);
	//        Attendance::insert($data);
	//        return redirect()->route('managers.index');
	//    }

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

	public function checkin(Request $request): RedirectResponse
	{
		Attendance::where('emp_id', '=', session('id'))
			->where('emp_role', '=', EmpRoleEnum::MANAGER)
			->where('date', '=', date('Y-m-d'))
			->where('shift', '=', $request->get('shift'))
			->update(['check_in' => date('H:i')]);
		session()->flash('noti', [
			'heading' => 'Check in successfully',
			'text'    => 'You\'ve checked in shift ' . $request->get('shift') . ' successfully',
			'icon'    => 'success',
		]);

		return redirect()->route('managers.index');
	}

	public function checkout(Request $request): RedirectResponse
	{
		Attendance::where('emp_id', '=', session('id'))
			->where('emp_role', '=', EmpRoleEnum::MANAGER)
			->where('date', '=', date('Y-m-d'))
			->where('shift', '=', $request->get('shift'))
			->update(['check_out' => date('H:i')]);
		session()->flash('noti', [
			'heading' => 'Check out successfully',
			'text'    => 'You\'ve checked out shift ' . $request->get('shift') . ' successfully',
			'icon'    => 'success',
		]);

		return redirect()->route('managers.index');
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

	public function assignment()
	{
		return view('managers.assignment');
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
