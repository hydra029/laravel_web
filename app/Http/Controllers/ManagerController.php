<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class ManagerController extends Controller
{

	public function __construct()
	{
		$this->middleware('manager');
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
	 * @return Application|Factory
	 */
	public function index()
	{
		$limit = 10;
		$fields = array('employees.*', 'roles.name as role_name');
		$dept_id = Manager::where('id','=',session('id'))
			->get('dept_id');
		$data = Employee::where('employees.status','=','1')
			->where('employees.dept_id','=',$dept_id->count())
			->leftJoin('roles', 'employees.role_id', '=', 'roles.id')
			->paginate($limit,$fields);

		return view('managers.index', [
			'data' => $data,
			'num'=> 1,
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
	 * @param StoreManagerRequest $request
	 * @return Response
	 */
	public function store(StoreManagerRequest $request): Response
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Manager $manager
	 * @return Response
	 */
	public function show(Manager $manager): Response
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Manager $manager
	 * @return Response
	 */
	public function edit(Manager $manager): Response
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdateManagerRequest $request
	 * @param Manager $manager
	 * @return Response
	 */
	public function update(UpdateManagerRequest $request, Manager $manager): Response
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Manager $manager
	 * @return Response
	 */
	public function destroy(Manager $manager): Response
	{
		//
	}
}
