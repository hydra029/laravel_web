<?php

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Enums\SignEnum;
use App\Http\Requests\StoreInformationRequest;
use App\Models\Accountant;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
use App\Models\Ceo;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Fines;
use App\Models\Manager;
use App\Models\Role;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class ApiController extends Controller
{
	public function __construct()
	{
		$routeName = Route::currentRouteName();
		$arr       = explode('.', $routeName);
		$arr[1]    = explode('_', $arr[1]);
		$arr[1]    = array_map('ucfirst', $arr[1]);
		$arr[1]    = implode(' ', $arr[1]);
		$arr       = array_map('ucfirst', $arr);
		$title     = implode(' - ', $arr);
		View::share('title', $title);
	}

	public function getShiftTimes()
	{
		return AttendanceShiftTime::get();
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

	public function getDepartments(Request $request): Collection
	{
		$data = Department::whereNull('deleted_at');
		$type = $request->get('type');
		if ($type === '3') {
			$data = $data->where('id','=','1');
		} else if ($type === '2') {
			$dept = Manager::whereNotNull('dept_id')->pluck('dept_id');
			$data = $data->whereNotIn ('id', $dept);
		} else {
			$data = $data->where('id','<>','1');
		}
		return $data->get(['id', 'name']);
	}

	public function getRoles(Request $request): Collection
	{
		$type = $request->get('type');
		$data = Role::whereNull('deleted_at')
		->where('dept_id', '=', $request->get('dept_id'));
		if ($type !== '2') {
			$data = $data->where('name', '<>', 'Manager');
		} else {
			$data = $data->where('name', '=', 'Manager');
		}
		return $data->get(['id', 'name']);
	}

	public function getPersonalSalary(Request $request)
	{
		$id        = $request->id;
		$dept_name = $request->dept_name;
		$role_name = $request->role_name;
		$month     = $request->month;
		$year      = $request->year;
		$fines     = Fines::get()->append('deduction_detail');
		$salary    = Salary::query()
			->where('emp_id', '=', $id)
			->where('month', '=', $month)
			->where('year', '=', $year)
			->where('dept_name', '=', $dept_name)
			->where('role_name', '=', $role_name)
			->where('sign', '=', SignEnum::CEO_SIGNED)
			->first();
		if ($salary === null) {
			return 0;
		}
		$salary
			->append(['salary_money', 'deduction_detail', 'pay_rate_money', 'bonus_salary_off_work_day', 'bonus_salary_over_work_day', 'deduction_late_one_detail', 'deduction_late_two_detail', 'deduction_early_one_detail', 'deduction_early_two_detail', 'deduction_miss_detail', 'pay_rate_over_work_day', 'pay_rate_off_work_day', 'pay_rate_work_day'])->toArray();
		$arr['salary'] = $salary;
		$arr['fines']  = $fines;
		return $arr;
	}

	public function confirmSalary(): int
	{
		$day = date('d');
		if ($day >= 15 && $day <= 20) {
			$month = date('m', strtotime('last month'));
			$year  = date('Y', strtotime('last month'));
			Salary::query()
				->where('emp_id', '=', session('id'))
				->where('month', '=', $month)
				->where('year', '=', $year)
				->where('dept_name', '=', session('dept_name'))
				->where('role_name', '=', session('role_name'))
				->update(['sign' => SignEnum::EMPLOYEE_CONFIRMED]);
			return 0;
		}
		return 1;
	}

	public function personalInformation()
	{
		$level = session('level');
		$id    = session('id');
		if ($level !== 4) {
			switch ($level) {
				case 1:
					$user = Employee::query();
					break;
				case 2:
					$user = Manager::query();
					break;
				default:
					$user = Accountant::query();
					break;
			}
			$data = $user->with(['roles', 'departments'])
				->where('id', '=', $id)
				->first();
		} else {
			$data = Ceo::where('id', '=', $id)
				->first();
		}
		$data->makeHidden(
			[
				'deleted_at',
				'updated_at',
				'created_at',
				'remember_token',
				'password'
			]
		)->append(['full_name', 'date_of_birth', 'gender_name', 'address']);
		return view(EmpRoleEnum::getKeyByValue($level) . '.profile', [
			'data' => $data,
		]);
	}

	public function updateInformation(StoreInformationRequest $request): string
	{
		$level = session('level');
		$id    = session('id');
		if ($request->password) {
			$data = $request->all();
		} else {
			$data = $request->except('password');
		}
		switch ($level) {
			case 1:
				$user = Employee::whereNull('deleted_at');
				break;
			case 2:
				$user = Manager::whereNull('deleted_at');
				break;
			case 3:
				$user = Accountant::whereNull('deleted_at');
				break;
			default:
				$user = Ceo::whereNull('deleted_at');
				break;
		}
		$user = $user->find($id);
		$user->fill($data)->save();
		if ($request->hasFile('avatar')) {
			$file = $request->file('avatar');
			$name = time() . '_' . $id . '_' . $level;
			$file->move(public_path() . '/uploads/', $name);
			$user->avatar = $name;
			$user->save();
		}
		return 'Update information successfully !';
	}
}
