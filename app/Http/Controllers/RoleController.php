<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class RoleController extends Controller
{
    public function __construct()
	{
		$this->middleware('ceo');
		$routeName = Route::currentRouteName();
		$arr = explode('.', $routeName);
		$arr = array_map('ucfirst', $arr);
		$title = implode(' - ', $arr);

		View::share('title', $title);
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @param StoreRoleRequest $request
     * @return Response
     */
    public function store(StoreRoleRequest $request)
    {
        $name = $request->name;
        $dept_id = $request->dept_id;
        $pay_rate = $request->pay_rate;
         Role::create([
            'name' => $name,
            'dept_id' => $dept_id,
            'pay_rate' => $pay_rate,
            'status' => '1',
         ]);
        $roles = Role::query()
        ->leftJoin('departments', 'roles.dept_id', '=', 'departments.id')
        ->select('roles.*', 'departments.name as dept_name')
        ->where('dept_id', '=', $dept_id)
        ->get();
        return $roles->append('pay_rate_money')->toArray();
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
