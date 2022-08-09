<?php

namespace App\Http\Controllers;

use App\Models\Accountant;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
use App\Models\Employee;
use App\Models\Fines;
use App\Models\Manager;
use App\Models\Salary;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function test()
	{
		return view('test', [
			'title' => 'Test'
		]);
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
		$dept  = $request->get('dept');
		$role  = $request->get('role');
		$month    = date('m', strtotime('last month'));
		$year     = date('Y', strtotime('last month'));
		$data[]   = Salary::query()
		->where('dept_name', '=',$dept)
		->where('role_name', '=',$role)
		->where('emp_id', '=',$emp_id)
		->where('month', '=',$month)
		->where('year', '=',$year)
		->first();
		$date = $request->get('date');
		$emp_role = $request->get('emp_role');
		$data[] = Attendance::query()
			->where('date', 'like', "%$date%")
			->where('emp_role', '=', $emp_role)
			->where('emp_id', '=', $emp_id)
			->get();
		return $data;
	}
}
