<?php

namespace App\Http\Controllers;

use App\Models\Ceo;
use App\Http\Requests\StoreCeoRequest;
use App\Http\Requests\UpdateCeoRequest;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

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

		\Illuminate\Support\Facades\View::share('title', $title);
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
