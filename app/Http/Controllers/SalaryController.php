<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Http\Requests\StoreSalaryRequest;
use App\Http\Requests\UpdateSalaryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Builder;
class SalaryController extends Controller
{
    public function __construct()
	{
		$this->middleware('ceo');
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
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        return view('ceo.salary');
    }

    public function salary_api(Request $request)
    {
        $month = request()->month;
        $year = request()->year;
        $salary = $this->model->with('emp')->where('month', $month)->where('year', $year)->get()->append(['salary_money','deduction_detail','pay_rate_money']);
        return $salary;
    }

    public function salary_detail(Request $request)
    {
        $id = request()->id;
        $dept_name = request()->dept_name;
        $role_name = request()->role_name;
        $month = request()->month;
        $year = request()->year;
        $salary = $this->model->with('emp')
        ->where('emp_id', $id)
        ->where('month', $month)
        ->where('year', $year)
        ->where('dept_name', $dept_name)
        ->where('role_name', $role_name)
        ->get()
        ->append(['salary_money','deduction_detail','pay_rate_money']);
        
        return $salary;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSalaryRequest $request
     * @return Response
     */
    public function store(StoreSalaryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Salary $salary
     * @return Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Salary $salary
     * @return Response
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSalaryRequest $request
     * @param Salary $salary
     * @return Response
     */
    public function update(UpdateSalaryRequest $request, Salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Salary $salary
     * @return Response
     */
    public function destroy(Salary $salary)
    {
        //
    }
}
