<?php

namespace App\Http\Controllers;

use App\Models\Accountant;
use App\Models\AttendanceShiftTime;
use App\Models\Department;
use App\Models\Fines;
use App\Models\Salary;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function test()
	{

		return view('test', [
			'title' => 'Test'
		]);
	}

	public function get_salary(Request $request): JsonResponse
	{
		$acct   = session('id');
		$month  = $request->month;
		$year   = $request->year;
		$dept   = Department::query()
			->where('acct_id', '=', $acct)
			->pluck('name');
		$salary = Salary::query()->with('emp')
			->where('month', $month)
			->where('year', $year)
			->whereIn('dept_name', $dept)
			->orderBy('dept_name')
			->paginate(20);
		$salary->append(['salary_money', 'deduction_detail', 'pay_rate_money', 'bonus_salary_total_off_work_day']);

		$arr['data']       = $salary->getCollection();
		$arr['pagination'] = $salary->linkCollection();
		return $this->successResponse($arr);
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
			->first()
			->append(['salary_money', 'deduction_detail', 'pay_rate_money', 'bonus_salary_off_work_day', 'bonus_salary_over_work_day', 'deduction_late_one_detail', 'deduction_late_two_detail', 'deduction_early_one_detail', 'deduction_early_two_detail', 'deduction_miss_detail', 'pay_rate_over_work_day', 'pay_rate_off_work_day', 'pay_rate_work_day'])->toArray();
		$arr['salary'] = $salary;
		$arr['fines']  = $fines;
		return $arr;
	}

}
