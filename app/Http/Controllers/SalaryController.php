<?php

namespace App\Http\Controllers;

use App\Enums\SignEnum;
use App\Models\Department;
use App\Models\Fines;
use App\Models\Salary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class SalaryController extends Controller
{
	use ResponseTrait;

	public function __construct()
	{
		$this->model = Salary::query();
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
		return view('ceo.salary');
	}

	public function getSalary(Request $request): JsonResponse
	{
		$month         = $request->month;
		$year          = $request->year;
		$department_id = $request->department;
		$salary        = Salary::with('emp')
			->where('month', $month)
			->where('year', $year)
			->whereNotNull('acct_id')
			->whereNotNull('sign');
		if ($department_id !== 'all') {
			$dept_name = Department::whereNull('deleted_at')
				->where('id', '=', $department_id)
				->pluck('name');
			$salary    = $salary->where('dept_name', $dept_name);
		}
		$salary = $salary->paginate(20);
		$salary
			->append(['salary_money', 'deduction_detail', 'pay_rate_money', 'bonus_salary_over_work_day', 'bonus_salary_total_off_work_day']);
		$arr['data']       = $salary->getCollection();
		$arr['pagination'] = $salary->linkCollection();
		return $this->successResponse($arr);
	}

	public function salaryDetail(Request $request): array
	{
		$id            = $request->id;
		$dept_name     = $request->dept_name;
		$role_name     = $request->role_name;
		$month         = $request->month;
		$year          = $request->year;
		$fines         = Fines::get()->append('deduction_detail');
		$salary        = $this->model->with('emp')
			->where('emp_id', $id)
			->where('month', $month)
			->where('year', $year)
			->where('dept_name', $dept_name)
			->where('role_name', $role_name)
			->get()
			->append(['salary_money', 'deduction_detail', 'pay_rate_money', 'bonus_salary_over_work_day', 'bonus_salary_off_work_day', 'deduction_late_one_detail', 'deduction_late_two_detail', 'deduction_early_one_detail', 'deduction_early_two_detail', 'deduction_miss_detail', 'pay_rate_over_work_day', 'pay_rate_off_work_day', 'pay_rate_work_day'])->toArray();
		$arr['salary'] = $salary;
		$arr['fines']  = $fines;
		return $arr;
	}
}
