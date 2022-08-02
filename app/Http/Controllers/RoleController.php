<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Department;
use Illuminate\Http\Response;
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
        $dept = Department::with('roles')->get();
        // dd($dept->toArray());
        return view('ceo.role' , compact('dept'));
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
    public function store(Request $request)
    {   
        try {
            $role = new Role();
            $role->id = Role::count() + 1;
            $role->dept_id = $request->dept_id;
            $role->name = $request->name;
            $role->pay_rate = $request->pay_rate;
            $role->save();
            return $this->successResponse($role, 'Role created successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error creating role');
        }
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
    public function update(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $dept_id = $request->dept_id;
        $pay_rate = $request->pay_rate;
        $data = Role::find($id);
        $data->name = $name;
        $data->dept_id = $dept_id;
        $data->pay_rate = $pay_rate;
        $data->save();
        return $data->append('pay_rate_money')->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $data = Role::find($id);
        $data->delete();
        return $this->successResponse([
            'message' => 'Delete success',
        ]);
    }
}
