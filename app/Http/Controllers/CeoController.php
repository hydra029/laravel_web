<?php

namespace App\Http\Controllers;

use App\Enums\ShiftEnum;
use App\Http\Requests\StoreAccountantRequest;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
use App\Models\Ceo;
use App\Http\Requests\StoreCeoRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateCeoRequest;
use App\Imports\AccountantsImport;
use App\Imports\EmployeesImport;
use App\Imports\ManagersImport;
use App\Models\Accountant;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Fines;
use App\Models\Manager;
use App\Models\Role;
use App\Models\Salary;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class CeoController extends Controller
{
	use ResponseTrait;

	public function __construct()
	{
		$this->middleware('ceo');
		$this->model = Manager::query();
		$routeName   = Route::currentRouteName();
		$arr         = explode('.', $routeName);
		$arr[1]      = explode('_', $arr[1]);
		$arr[1]      = array_map('ucfirst', $arr[1]);
		$arr[1]      = implode(' ', $arr[1]);
		$arr         = array_map('ucfirst', $arr);
		$title       = implode(' - ', $arr);

		View::share('title', $title);
	}

	/**
	 * Display a listing of the resource.
	 *
	 */
	public function index()
	{
		$limit  = 11;
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
		$data   = Employee::whereNull('deleted_at')
			->with(['roles', 'departments'])
			->orderBy('dept_id', 'ASC')
			->paginate($limit, $fields);
		$acc    = Accountant::whereNull('deleted_at')
			->with(['roles', 'departments'])
			->paginate(11);
		return view(
			'ceo.index',
			([
				'acc'  => $acc,
				'data' => $data,
				'num'  => 1,
			])
		);
	}

	public function get_infor()
	{
		$id   = session('id');
		$data = Ceo::whereId($id)->first();

		$dept = Department::get();
		return view('ceo.profile', [
			'data' => $data,
			'dept' => $dept,
		]);
	}

	public function time()
	{
		$time  = AttendanceShiftTime::get();
		$count = AttendanceShiftTime::count();
		return view('ceo.time', [
			'time'  => $time,
			'count' => $count,
		]);
	}

	public function time_change(Request $request)
	{

		$time = AttendanceShiftTime::where('id','=',$request->get('id'))->first();
		if ($time) {
			$time->fill($request->all());
			$time->save();

		}
		return $time;
	}

	public function employee_attendance(): Renderable
	{
		return view('ceo.employee_attendance');
	}

	public function attendance_api(Request $request): array
	{
		$dept_id = $request->dept_id;
		$s       = $request->s;
		$m       = $request->m;
		$data[]  = AttendanceShiftTime::get();
		if ($dept_id === '1') {
			$data[] = Manager::with(
				[
					'attendance' => function ($query) use ($s, $m) {
						$query->where('date', '<=', $s)->where('date', '>=', $m);
					},
					'departments',
					'roles',
				]
			)
				->whereNull('deleted_at')
				->where('dept_id','=',$dept_id)
				->get(['id', 'lname', 'fname', 'dept_id', 'role_id']);
			$data[] = Accountant::with(
				[
					'attendance' => function ($query) use ($s, $m) {
						$query->where('date', '<=', $s)->where('date', '>=', $m);
					},
					'departments',
					'roles',
				]
			)
				->whereNull('deleted_at')
				->get(['id', 'lname', 'fname', 'dept_id', 'role_id']);
		} else {
			$data[] = Manager::with(
				[
					'attendance' => function ($query) use ($s, $m) {
						$query->where('date', '<=', $s)->where('date', '>=', $m);
					},
					'departments',
					'roles',
				]
			)
				->whereNull('deleted_at')
				->where('dept_id','=',$dept_id)
				->get(['id', 'lname', 'fname', 'dept_id', 'role_id']);
			$data[] = Employee::with(
				[
					'attendance' => function ($query) use ($s, $m) {
						$query->where('date', '<=', $s)->where('date', '>=', $m);
					},
					'departments',
					'roles',
				]
			)
				->whereNull('deleted_at')
				->where('dept_id','=',$dept_id)
				->get(['id', 'lname', 'fname', 'dept_id', 'role_id']);
		}
		return $data;
	}

	public function emp_attendance_api(Request $request)
	{
		$date     = $request->get('date');
		$emp_role = $request->get('role');
		$emp_id   = $request->get('id');
		return Attendance::query()
			->where('date', 'like', "%$date%")
			->where('emp_role', '=', $emp_role)
			->where('emp_id', '=', $emp_id)
			->get();
	}

	public function department_api()
	{
		return Department::get(['id', 'name']);
	}

	public function fines_store(Request $request): array
	{
		$name      = $request->name;
		$fines     = $request->fines;
		$deduction = $request->deduction;
		return Fines::create([
			'name'      => $name,
			'fines'     => $fines,
			'deduction' => $deduction,
		])->append(['fines_time', 'deduction_detail'])->toArray();
	}

	public function fines_update(Request $request): array
	{
		$id        = $request->id;
		$name      = $request->name;
		$fines     = $request->fines;
		$deduction = $request->deduction;
		Fines::query()
			->where('id', $id)
			->update([
				'name'      => $name,
				'fines'     => $fines,
				'deduction' => $deduction,
			]);
		return Fines::whereId($id)->get()->append(['fines_time', 'deduction_detail'])->toArray();
	}

	public function import_employee(Request $request): void
	{
		$request->validate([
			'file' => 'required|max:10000|mimes:xlsx,xls',
		]);
		$path = $request->file;

		Excel::import(new EmployeesImport, $path);
	}

	public function import_acct(Request $request): void
	{
		$request->validate([
			'file' => 'required|max:10000|mimes:xlsx,xls',
		]);
		$path = $request->file;

		Excel::import(new AccountantsImport, $path);
	}

	public function import_mgr(Request $request): void
	{
		$request->validate([
			'file' => 'required|max:10000|mimes:xlsx,xls',
		]);
		$path = $request->file;

		Excel::import(new  ManagersImport, $path);
	}

	public function create_emp()
	{
		$dept = Department::get();
		return view('ceo.create', [
			'dept' => $dept,
		]);
	}

	public function select_role(Request $Request)
	{
		$dept_id = $Request->dept_id;
		return Role::query()->where('dept_id', $dept_id)->get();
	}

	public function store_emp(StoreEmployeeRequest $storeEmployeeRequest): array
	{
		$arr = $storeEmployeeRequest->validated();
		if ($storeEmployeeRequest->file('avatar')) {
			$avatar     = $storeEmployeeRequest->file('avatar');
			$avatarName = date('YmdHi') . $avatar->getClientOriginalName();
			$avatar->move(public_path('img'), $avatarName);
			$arr['avatar'] = $avatarName;
		}
		$hashPassword    = Hash::make($storeEmployeeRequest->get('password'));
		$arr['password'] = $hashPassword;
		$role_id         = $storeEmployeeRequest->get('role_id');
		$role            = Role::query()->with('departments')->where('id', $role_id)->get();
		$emp             = Employee::query()->create($arr)->append(['full_name', 'date_of_birth', 'gender_name', 'address'])->toArray();
		return [$role, $emp];
	}

	public function employee_infor(Request $request): array
	{
		$id = $request->get('id');
		return Employee::query()->with(['roles', 'departments'])->whereId($id)->get()->append(['full_name', 'date_of_birth', 'gender_name', 'address'])->toArray();
	}

	public function update_emp(StoreEmployeeRequest $storeEmployeeRequest): void
	{
		$arr = $storeEmployeeRequest->validated();
		Employee::query()->update($arr);
	}

	public function delete_emp(Request $request): JsonResponse
	{
		$id = $request->get('id');
		Employee::query()->whereId($id)->delete();
		return $this->successResponse([
			'message' => 'Delete success',
		]);
	}

	public function store_acct(StoreAccountantRequest $storeAccountantRequest): array
	{
		$arr = $storeAccountantRequest->validated();
		if ($storeAccountantRequest->file('avatar')) {
			$avatar     = $storeAccountantRequest->file('avatar');
			$avatarName = date('YmdHi') . $avatar->getClientOriginalName();
			$avatar->move(public_path('img'), $avatarName);
			$arr['avatar'] = $avatarName;
		}
		$hashPassword    = Hash::make($storeAccountantRequest->get('password'));
		$arr['password'] = $hashPassword;
		$role_id         = $storeAccountantRequest->get('role_id');
		$role            = Role::query()->with('departments')->where('id', $role_id)->get();
		$emp             = Accountant::query()->create($arr)->append(['full_name', 'date_of_birth', 'gender_name', 'address'])->toArray();
		return [$role, $emp];
	}

	public function store_mgr(StoreManagerRequest $storeManagerRequest): array
	{
		$arr = $storeManagerRequest->validated();
		if ($storeManagerRequest->file('avatar')) {
			$avatar     = $storeManagerRequest->file('avatar');
			$avatarName = date('YmdHi') . $avatar->getClientOriginalName();
			$avatar->move(public_path('img'), $avatarName);
			$arr['avatar'] = $avatarName;
		}
		$hashPassword    = Hash::make($storeManagerRequest->get('password'));
		$arr['password'] = $hashPassword;
		$role_id         = $storeManagerRequest->get('role_id');
		$role            = Role::query()->with('departments')->where('id', $role_id)->get();
		$emp             = Manager::query()->create($arr)->append(['full_name', 'date_of_birth', 'gender_name', 'address'])->toArray();
		return [$role, $emp];
	}

	
    public function salary()
    {
        return view('ceo.salary');
    }

	public function sign_salary(Request $request): JsonResponse
	{
		try {
			$response = $request->all();
			foreach ($response['data'] as $request => $data ) {
				$id = $data['id'];
				$dept_name = $data['dept_name'];
				$role_name = $data['role_name'];
				$month = $data['month'];
				$year = $data['year'];
				$salary = Salary::query()
				->where('emp_id', $id)
				->where('dept_name', $dept_name)
				->where('role_name', $role_name)
				->where('month', $month)
				->where('year', $year)
				->update(['sign' => 1]);
			}
			return $this->successResponse([
				'message' => 'Sign success',
			]);
		} catch (\Exception $e) {
			return $this->errorResponse([
				'message' => $e->getMessage(),
			]);
		}
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
	 * @param StoreCeoRequest $request
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
	 * @param UpdateCeoRequest $request
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
