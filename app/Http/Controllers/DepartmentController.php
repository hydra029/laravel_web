<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class DepartmentController extends Controller
{
    private Builder $models;

    public function __construct()
    {
		$this->middleware('ceo');
        $this->models = Department::query();
        $routeName = Route::currentRouteName();
		$arr = explode('.', $routeName);
		$arr = array_map('ucfirst', $arr);
		$title = implode(' - ', $arr);

		View::share('title', $title);
    }
    public function index()
    {
       $dept = $this->models->with('manager')->withCount(['members','roles'])->get();
       return view('ceo.department', [
           'dept' => $dept,
       ]);
    }

    public function department_employees(Request $request)
    {
        $dept_id = $request->get('dept_id');
        $employee_dept = Employee::query()
        ->leftJoin('departments', 'employees.dept_id', '=', 'departments.id')
        ->leftJoin('roles', 'employees.role_id', '=', 'roles.id')
        ->select('employees.*', 'departments.name as dept_name', 'roles.name as role_name')
        ->where('employees.dept_id', '=', $dept_id)
        ->get();
        return $employee_dept->append(['full_name','date_of_birth','gender_name','address']);
    }

    public function manager_role(Request $request)
    {
        $role_id = $request->role_id;
        return Role::whereId($role_id)->get();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(StoreDepartmentRequest $request)
    {
        $arr = $request->validated();
        $this->models->create($arr);

        return redirect()->route('ceo.department')  ->with('success', 'Đã thêm mới thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param Department $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Department $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $dept_id = $request->dept_id;
        $dept_name = $request->name;
        Department::where('id', $dept_id)->update(['name' => $dept_name]);
        return Department::whereId($dept_id)->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Department $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }
}
