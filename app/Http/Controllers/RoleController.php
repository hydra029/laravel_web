<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Department;
use App\Models\Role;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class RoleController extends Controller
{
	use ResponseTrait;

	public function __construct()
	{
		$this->middleware('ceo');
		$routeName = Route::currentRouteName();
		$arr       = explode('.', $routeName);
		$arr       = array_map('ucfirst', $arr);
		$title     = implode(' - ', $arr);

		View::share('title', $title);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Application|Factory|\Illuminate\Contracts\View\View
	 */
	public function index()
	{
		$dept = Department::with('roles')
			->whereNull('deleted_at')
			->get();
		return view('ceo.role', compact('dept'));
	}

	public function store(Request $request): JsonResponse
	{
		try {
			$role           = new Role();
			$role->id       = Role::count() + 1;
			$role->dept_id  = $request->dept_id;
			$role->name     = $request->name;
			$role->pay_rate = $request->pay_rate;
			$role->save();
			return $this->successResponse($role, 'Role created successfully');
		}
		catch (Exception $e) {
			return $this->errorResponse($e->getMessage(), 'Error creating role');
		}
	}

	public function update(Request $request): string
	{
		$id             = $request->id;
		$name           = $request->name;
		$dept_id        = $request->dept_id;
		$pay_rate       = $request->pay_rate;
		$data           = Role::find($id);
		$data->name     = $name;
		$data->dept_id  = $dept_id;
		$data->pay_rate = $pay_rate;
		$data->save();
		return $data->append('pay_rate_money')->toJson();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function destroy(Request $request): JsonResponse
	{
		$id   = $request->id;
		$data = Role::find($id);
		$data->delete();
		return $this->successResponse(
			[
				'message' => 'Delete success',
			]
		);
	}
}
