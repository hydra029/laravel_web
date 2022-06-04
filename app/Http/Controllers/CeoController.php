<?php

namespace App\Http\Controllers;

use App\Models\Attendance_shift_time;
use App\Models\Ceo;
use App\Http\Requests\StoreCeoRequest;
use App\Http\Requests\UpdateCeoRequest;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class CeoController extends Controller
{
	public function __construct()
	{
		$this->middleware('ceo');
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
	    $limit = 25;
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

	public function time()
	{
		$time = Attendance_shift_time::get();
		return view('ceo.time', [
			'time' => $time,
		]);
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
     * @param  \App\Http\Requests\StoreCeoRequest  $request
     * @return Response
     */
    public function store(StoreCeoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Ceo $ceo
     * @return Response
     */
    public function show(Ceo $ceo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ceo $ceo
     * @return Response
     */
    public function edit(Ceo $ceo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCeoRequest  $request
     * @param Ceo $ceo
     * @return Response
     */
    public function update(UpdateCeoRequest $request, Ceo $ceo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ceo $ceo
     * @return void
     */
    public function destroy(Ceo $ceo)
    {
        //
    }
}
