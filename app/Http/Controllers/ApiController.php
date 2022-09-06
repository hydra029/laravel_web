<?php

namespace App\Http\Controllers;

use App\Enums\SignEnum;
use App\Models\AttendanceShiftTime;
use App\Models\Department;
use App\Models\Fines;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ApiController extends Controller
{
	public function __construct()
	{
//		$this->middleware(['auth:sanctum']);
	}

	public function getShiftTimes()
	{
		return AttendanceShiftTime::get();
	}

	public function getDepartments(): Collection
	{
		return Department::whereNull('deleted_at')
			->get(['id', 'name']);
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
		$month  = date('m', strtotime('last month'));
		$year   = date('Y', strtotime('last month'));
		Salary::query()
			->where('emp_id', '=', session('id'))
			->where('month', '=', $month)
			->where('year', '=', $year)
			->where('dept_name', '=', session('dept_name'))
			->where('role_name', '=', session('role_name'))
			->update(['sign' => SignEnum::EMPLOYEE_CONFIRMED]);
		return 0;
	}
}
