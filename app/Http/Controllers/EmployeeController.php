<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class EmployeeController extends Controller
{

	public function __construct()
	{
		$this->model = Employee::query();
		$routeName = Route::currentRouteName();
		$arr = explode('.', $routeName);
		$arr = array_map('ucfirst', $arr);
		$title = implode(' - ', $arr);

		\Illuminate\Support\Facades\View::share('title', $title);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Application|Factory  \Contracts\View\View
	 */
	public function index()
	{
		$date = date_format(date_create(), 'd-m-Y');
		$email = session('email');
		if ($user = Employee::query()
			->where('email', session('email'))
			->where('password', session('password'))
			->first()) {
			session()->put('id', $user->id);
		}
		$id = session('id');


		$data = Attendance::where('emp_id', '=', $id)
			->where('date', '=', $date)
			->exists();
		dd($date);
		return view('employees.index', [
			'data' => $data,
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
	 * @param StoreEmployeeRequest $request
	 * @return void
	 */
	public function store(StoreEmployeeRequest $request): void
	{
		$users = Employee::query()->get('id');

		foreach ($users as $each) {
			$date = date_format(date_create(), 'd-m-Y');

			for ($i = 1; $i <= 3; $i++) {
				$data = array('emp_id' => $each->id, 'date' => $date, 'shift' => $i);
				Attendance::create($data);
			}
		}
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

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdateEmployeeRequest $request
	 * @param Employee $employee
	 * @return void
	 */
	public function update(UpdateEmployeeRequest $request, Employee $employee): void
	{
		//
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
