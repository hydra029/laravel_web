<?php

namespace App\Http\Controllers;

use App\Models\Accountant;
use App\Http\Requests\StoreAccountantRequest;
use App\Http\Requests\UpdateAccountantRequest;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AccountantController extends Controller
{
	public function __construct()
	{
		$this->middleware('accountant');
		$this->model = Manager::query();
		$routeName = Route::currentRouteName();
		$arr = explode('.', $routeName);
		$arr = array_map('ucfirst', $arr);
		$title = implode(' - ', $arr);

		View::share('title', $title);
	}

	/**
	 * Display a listing of the resource.
	 *
	 */
	public function index()
	{
		$limit = 20;
		$fields = array('employees.*', 'departments.name as dept_name', 'roles.name as role_name');
		$data = Employee::where('employees.status','=','1')
			->where('departments.status','=','1')
			->where('roles.status','=','1')
			->leftJoin('departments', 'employees.dept_id', '=', 'departments.id')
			->leftJoin('roles', 'employees.role_id', '=', 'roles.id')
			->paginate($limit, $fields);

		return view('ceo.index', [
			'data' => $data,
		]);
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
		return view('accountants.month_attendance', ([
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAccountantRequest $request
     * @return Response
     */
    public function store(StoreAccountantRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accountant  $accountant
     * @return Response
     */
    public function show(Accountant $accountant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accountant  $accountant
     * @return Response
     */
    public function edit(Accountant $accountant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAccountantRequest  $request
     * @param  \App\Models\Accountant  $accountant
     * @return Response
     */
    public function update(UpdateAccountantRequest $request, Accountant $accountant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accountant  $accountant
     * @return Response
     */
    public function destroy(Accountant $accountant)
    {
        //
    }
}
