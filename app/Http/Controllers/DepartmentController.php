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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Mail;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class DepartmentController extends Controller
{

    use ResponseTrait;
    public function __construct()
    {
		$this->middleware('ceo');
		$this->models = new Department();
		$routeName = Route::currentRouteName();
		$arr = explode('.', $routeName);
		$arr = array_map('ucfirst', $arr);
		$title = implode(' - ', $arr);

		View::share('title', $title);
    }
    public function index()
    {
       $dept = $this->models->with('manager')->withCount(['members','roles'])->paginate(8);
	   $manager = Manager::all();
       return view('ceo.department', [
           'dept' => $dept,
		   'manager' => $manager,
       ]);
    }

    public function department_employees(Request $request): JsonResponse
    {
        $dept_id = $request->get('dept_id');
        $data = Employee::query()->with('departments', 'roles')
        ->where('employees.dept_id', '=', $dept_id)
        ->paginate(10);
        foreach ($data as $each){
            $each->full_name = $each->full_name ;
            $each->gender_name = $each->gender_name ;
            $each->address = $each->address ;
            $each->date_of_birth = $each->date_of_birth ;
        }
        $arr['data'] = $data->getCollection();
        $arr['pagination'] = $data->linkCollection();
        return $this->successResponse($arr);

    }


	public function manager_role(Request $request)
	{
		$role_id = $request->role_id;
		return Role::whereId($role_id)->get();
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

	public function store(StoreDepartmentRequest $request)
	{
		$arr = $request->validated();
		$data['name'] = $arr['name'];	
		 $this->models::create($data);
		$dept_id = $this->models::max('id');
		Role::create([
			'name' => $data['name'] . ' Manager',
			'dept_id' => $dept_id,
			'pay_rate' => 1000000,
		]);
		$role_id = Role::max('id');
		if($arr['manager_id'] != null){
			$manager = Manager::find($arr['manager_id']);
			$manager->dept_id = $dept_id;
			$manager->role_id = $role_id;
			$manager->save();
		}
		session()->flash('noti', [
			'heading' => 'Add department successfully',
			'text' => '',
			'icon' => 'success',
		]);
		return redirect()->route('ceo.department');
	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Department $department
	 * @return void
	 */
	public function show(Department $department)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Department $department
	 * @return void
	 */
	public function edit(Department $department)
	{
		//
	}

	public function update(Request $request)
	{	
		$id_manager = $request->id_manager;
		$dept_id = $request->id;
		$dept_name = $request->name;
		Department::where('id', $dept_id)->update(['name' => $dept_name]);
		if($id_manager != null){
			$manager = Manager::find($id_manager);
			$manager->dept_id = $dept_id;
			$manager->save();
		}
		return Department::whereId($dept_id)->with('manager')->withCount(['members','roles'])->get();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Department $department
	 * @return Response
	 */
	public function destroy(Request $request)
	{
		$id = $request->dept_id	;
		$dept = Department::find($id);
		$dept->delete();
		return $this->successResponse(['message' => 'Delete department successfully']);
	}
}
