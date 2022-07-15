<?php

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Enums\ShiftStatusEnum;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
use App\Models\Employee;
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
		$arr = explode('.', $routeName);
		$arr = array_map('ucfirst', $arr);
		$title = implode(' - ', $arr);

		View::share('title', $title);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Application|Factory  \Contracts\View\View
	 */
	public function index()
	{
		$date = date('Y-m-d');
		$emp_role = EmpRoleEnum::Employee;
		$query = [
			'attendances.check_in as check_in',
			'attendances.check_out as check_out',
			'attendance_shift_times.id as shift_id',
			'attendance_shift_times.status as status'
		];
		$data = Attendance::where('emp_id', '=', session('id'))
			->where('date', '=', $date)
			->where('emp_role', '=', $emp_role)
			->leftJoin('attendance_shift_times', 'attendances.shift', '=', 'attendance_shift_times.id')
			->get($query);
		return view('employees.index', [
			'data' => $data,
		]);
	}

    public function employee_infor(Request $request)
    {
        $id = $request->get('id');
        return Employee::query()->whereId($id)->first();
    }

	public function attendance(): Renderable
	{
		$limit = 25;
		$fields = [
			'id',
			'fname',
			'lname',
			'gender',
			'dob',
			'email',
			'role_id',
			'dept_id',
		];
		$data = Employee::whereStatus(1)
			->with(['roles', 'departments'])
			->paginate($limit, $fields);
		$id = session('id');
		$attendance = Employee::with('attendance')
			->where('id', '=', $id)
			->first();
		return view('employees.month_attendance', ([
			'data' => $data,
			'attendance' => $attendance,
		]));
	}

	/**
	 * @throws \JsonException
	 */
	public function attendance_api()
	{
		$a = Employee::with('attendance')
			->where('id', '=', session('id'))
			->first('id');
		return json_decode($a, false, 512, JSON_THROW_ON_ERROR);
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
	public function store(StoreEmployeeRequest $request): RedirectResponse
	{

	}

	public function add(): RedirectResponse
	{
		$users = Employee::get('id');
		foreach ($users as $each) {
			$date = date('Y-m-d', mktime(0, 0, 0, 7, 15, 2022));
			for ($i = 1; $i <= 3; $i++) {
				$data = array('emp_id' => $each->id, 'date' => $date, 'shift' => $i);
				Attendance::create($data);
			}
		}
		return redirect()->route('employees.index');
	}

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

	public function checkin(): RedirectResponse
	{
		$date = date('H:i');
		$status = ShiftStatusEnum::Active;
		$start_time = AttendanceShiftTime::where('id', '=', $status)->get('check_in_start');
		$end_time = AttendanceShiftTime::where('id', '=', $status)->get('check_in_end');
		if ($date >= $start_time && $date <= $end_time) {
			Attendance::where('emp_id', '=', session('id'))
				->where('shift', '=', 2)
				->update(['check_in' => 1]);
		}
		return redirect()->route('employees.index');
	}

	public function checkout(): RedirectResponse
	{
		$date = date('H:i');
		$shift = Attendance::where('status', '=', 2)->get('id');
		$start_time = AttendanceShiftTime::where('id', '=', $shift)->get('check_out_start');
		$end_time = AttendanceShiftTime::where('id', '=', $shift)->get('check_out_end');
		if ($date >= $start_time && $date <= $end_time) {
			Attendance::where('emp_id', '=', session('id'))
				->where('shift', '=', $shift)
				->update(['check_out' => 1]);
		}
		return redirect()->route('employees.index');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdateEmployeeRequest $request
	 * @param Employee $employee
	 * @return void
	 */
	public function update(UpdateEmployeeRequest $request, Employee $employee): void
	{
	}

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
