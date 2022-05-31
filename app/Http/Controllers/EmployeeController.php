<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Manager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class EmployeeController extends Controller
{

	public function __construct()
	{
		$this->model = (new Employee->query());
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
//	    $data = Employee::get();
	    $data   = Employee::query()
		    ->paginate(2);

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
        //
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
