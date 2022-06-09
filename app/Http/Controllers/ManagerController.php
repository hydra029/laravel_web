<?php

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Enums\ShiftEnum;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class ManagerController extends Controller
{

	public function __construct()
	{
		$this->middleware('manager');
		$this->model = Manager::query();
		$routeName = Route::currentRouteName();
		$arr = explode('.', $routeName);
		$arr = array_map('ucfirst', $arr);
		$title = implode(' - ', $arr);

		View::share('title', $title);
	}


	public function index()
	{
		$date = date('Y-m-d');
		$emp_role = EmpRoleEnum::Manager;
		$query = [
			'attendances.check_in as check_in',
			'attendances.check_out as check_out',
			'attendance_shift_times.id as shift_id',
			'attendance_shift_times.status as status'
		];
		$data = Attendance::where('emp_id', '=', session('id'))
			->where('date', '=', $date)
			->where('emp_role', '=', $emp_role)
			->leftJoin('attendance_shift_times', 'attendances.shift','=','attendance_shift_times.id')
			->get($query);
		return view('managers.index', [
			'data' => $data,
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Application|Factory
	 */
	public function attendance()
	{
		$limit = 10;
		$date = date('Y-m-d');
		$dept_id = Manager::where('id', '=', session('id'))
			->get('dept_id');
		$data = Employee::addSelect(['employees.lname', 'employees.fname', 'roles.name as role_name'])
			->addSelect(['check_in_1' => Attendance::select('check_in')
				->whereColumn('attendances.emp_id', 'employees.id')
				->where('attendances.emp_role', '=', EmpRoleEnum::Employee)
				->where('attendances.shift', '=', ShiftEnum::Morning)
				->where('attendances.date', '=', $date)])
			->addSelect(['check_out_1' => Attendance::select('check_out')
				->whereColumn('attendances.emp_id', '=', 'employees.id')
				->where('attendances.emp_role', '=', EmpRoleEnum::Employee)
				->where('attendances.shift', '=', ShiftEnum::Morning)
				->where('attendances.date', '=', $date)])
			->addSelect(['check_in_2' => Attendance::select('check_in')
				->whereColumn('attendances.emp_id', '=', 'employees.id')
				->where('attendances.emp_role', '=', EmpRoleEnum::Employee)
				->where('attendances.shift', '=', ShiftEnum::Afternoon)
				->where('attendances.date', '=', $date)])
			->addSelect(['check_out_2' => Attendance::select('check_out')
				->whereColumn('attendances.emp_id', '=', 'employees.id')
				->where('attendances.emp_role', '=', EmpRoleEnum::Employee)
				->where('attendances.shift', '=', ShiftEnum::Afternoon)
				->where('attendances.date', '=', $date)])
			->addSelect(['check_in_3' => Attendance::select('check_in')
				->whereColumn('attendances.emp_id', '=', 'employees.id')
				->where('attendances.emp_role', '=', EmpRoleEnum::Employee)
				->where('attendances.shift', '=', ShiftEnum::Evening)
				->where('attendances.date', '=', $date)])
			->addSelect(['check_out_3' => Attendance::select('check_out')
				->whereColumn('attendances.emp_id', '=', 'employees.id')
				->where('attendances.emp_role', '=', EmpRoleEnum::Employee)
				->where('attendances.shift', '=', ShiftEnum::Evening)
				->where('attendances.date', '=', $date)])
			->where('employees.status', '=', 1)
			->where('employees.dept_id', '=', $dept_id->count())
			->leftJoin('roles as roles', 'employees.role_id', '=', 'roles.id')
			->paginate($limit);
		$shifts = ShiftEnum::getKeys();
		return view('managers.attendance', [
			'data' => $data,
			'num' => 1,
			'shifts' => $shifts,
		]);
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
