<?php

namespace App\Http\Controllers;

use App\Enums\SignEnum;
use App\Http\Requests\StoreAccountantRequest;
use App\Http\Requests\StoreCeoRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateCeoRequest;
use App\Imports\AccountantsImport;
use App\Imports\EmployeesImport;
use App\Imports\ManagersImport;
use App\Models\Accountant;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
use App\Models\Ceo;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Fines;
use App\Models\Manager;
use App\Models\Role;
use App\Models\Salary;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
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
		$dept    = Department::with('manager')->withCount(['members', 'roles', 'acctmembers'])->paginate(10);
		$manager = Manager::all();
		return view('ceo.index', [
			'dept'    => $dept,
			'manager' => $manager,
		]);
	}

	public function getInformation()
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

	public function timeChange(Request $request)
	{
		$time = AttendanceShiftTime::where('id', '=', $request->get('id'))->first();
		if ($time) {
			$time->fill($request->all());
			$time->save();
		}
		return $time;
	}

	public function employeeAttendance(): Renderable
	{
		return view('ceo.employee_attendance');
	}

	public function accessToken()
	{
		return session('access_token');
	}

	public function attendanceApi(Request $request): array
	{
		$dept_id = $request->dept_id;
		$s       = $request->s;
		$m       = $request->m;
		$data[]  = AttendanceShiftTime::get();
		if ($dept_id === '1') {
			$dept = Accountant::query();
		} else {
			$dept = Employee::query();
		}
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
			->where('dept_id', '=', $dept_id)
			->get(['id', 'lname', 'fname', 'dept_id', 'role_id']);
		$data[] = $dept
			->with([
				       'attendance' => function ($query) use ($s, $m) {
					       $query->where('date', '<=', $s)->where('date', '>=', $m);
				       },
				       'departments',
				       'roles',
			       ])
			->whereNull('deleted_at')
			->where('dept_id', '=', $dept_id)
			->get(['id', 'lname', 'fname', 'dept_id', 'role_id']);
		return $data;
	}

	public function employeeAttendanceApi(Request $request)
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

	public function departmentApi(): Collection
	{
		return Department::whereNull('deleted_at')
			->get(['id', 'name']);
	}

	public function fines_store(Request $request): array
	{
		$name      = $request->name;
		$fines     = $request->fines;
		$deduction = $request->deduction;
		return Fines::create(
			[
				'name'      => $name,
				'fines'     => $fines,
				'deduction' => $deduction,
			]
		)->append(['fines_time', 'deduction_detail'])->toArray();
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

	public function fines_update(Request $request): array
	{
		$id        = $request->id;
		$name      = $request->name;
		$fines     = $request->fines;
		$deduction = $request->deduction;
		Fines::query()
			->where('id', $id)
			->update(
				[
					'name'      => $name,
					'fines'     => $fines,
					'deduction' => $deduction,
				]
			);
		return Fines::whereId($id)->get()->append(['fines_time', 'deduction_detail'])->toArray();
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

	public function importEmployee(Request $request): void
	{
		$request->validate(
			[
				'file' => 'required|max:10000|mimes:xlsx,xls',
			]
		);
		$path = $request->file;

		Excel::import(new EmployeesImport, $path);
	}

	public function importAccountant(Request $request): void
	{
		$request->validate([
			                   'file' => 'required|max:10000|mimes:xlsx,xls',
		                   ]);
		$path = $request->file;

		Excel::import(new AccountantsImport, $path);
	}

	public function importManager(Request $request): void
	{
		$request->validate([
			                   'file' => 'required|max:10000|mimes:xlsx,xls',
		                   ]);
		$path = $request->file;

		Excel::import(new  ManagersImport, $path);
	}

	public function createEmployee()
	{
		$dept = Department::get();
		return view('ceo.create', [
			'dept' => $dept,
		]);
	}

	public function selectRole(Request $Request)
	{
		$dept_id = $Request->dept_id;
		return Role::where('dept_id', $dept_id)->get();
	}

	public function storeEmployee(StoreEmployeeRequest $storeEmployeeRequest): array
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
		$role            = Role::with('departments')
			->where('id', $role_id)
			->get();
		$emp             = Employee::create($arr)
			->append(['full_name', 'date_of_birth', 'gender_name', 'address'])
			->toArray();
		return [$role, $emp];
	}

	public function employeeInformation(Request $request): array
	{
		$id       = $request->get('id');
		$employee = Employee::with(['roles', 'departments'])
			->where('id', '=', $id)
			->get();
		return $employee
			->append(['full_name', 'date_of_birth', 'gender_name', 'address'])
			->toArray();
	}

	public function updateEmployee(StoreEmployeeRequest $request): void
	{
		$arr = $request->validated();
		Employee::query()->update($arr);
	}

	public function deleteEmployee(Request $request): JsonResponse
	{
		$id = $request->get('id');
		Employee::where('id', '=', $id)->delete();
		return $this->successResponse(
			[
				'message' => 'Delete success',
			]
		);
	}

	public function storeAccountant(StoreAccountantRequest $request): array
	{
		$arr = $request->validated();
		if ($request->file('avatar')) {
			$avatar     = $request->file('avatar');
			$avatarName = date('YmdHi') . $avatar->getClientOriginalName();
			$avatar->move(public_path('img'), $avatarName);
			$arr['avatar'] = $avatarName;
		}
		$hashPassword    = Hash::make($request->get('password'));
		$arr['password'] = $hashPassword;
		$role_id         = $request->get('role_id');
		$role            = Role::with('departments')
			->where('id', $role_id)
			->get();
		$emp             = Accountant::create($arr)
			->append(['full_name', 'date_of_birth', 'gender_name', 'address'])->toArray();
		return [$role, $emp];
	}

	public function storeManager(StoreManagerRequest $request): array
	{
		$arr = $request->validated();
		if ($request->file('avatar')) {
			$avatar     = $request->file('avatar');
			$avatarName = date('YmdHi') . $avatar->getClientOriginalName();
			$avatar->move(public_path('img'), $avatarName);
			$arr['avatar'] = $avatarName;
		}
		$hashPassword    = Hash::make($request->get('password'));
		$arr['password'] = $hashPassword;
		$role_id         = $request->get('role_id');
		$role            = Role::with('departments')
			->where('id', $role_id)
			->get();
		$emp             = Manager::create($arr)
			->append(['full_name', 'date_of_birth', 'gender_name', 'address'])
			->toArray();
		return [$role, $emp];
	}

	public function salary()
	{
		return view('ceo.salary');
	}

	public function employeeSalary()
	{
		return view('ceo.employee_salary');
	}

	public function signSalary(Request $request): JsonResponse
	{
		try {
			$response = $request->all();
			foreach ($response['data'] as $rq => $data) {
				$id        = $data['id'];
				$dept_name = $data['dept_name'];
				$role_name = $data['role_name'];
				$month     = $data['month'];
				$year      = $data['year'];
				$salary    = Salary::query()
					->where('emp_id', $id)
					->where('dept_name', $dept_name)
					->where('role_name', $role_name)
					->where('month', $month)
					->where('year', $year)
					->update(['sign' => SignEnum::CEO_SIGNED]);
			}
			return $this->successResponse(
				[
					'message' => 'Sign success',
				]
			);
		}
		catch (Exception $e) {
			return $this->errorResponse(
				[
					'message' => $e->getMessage(),
				]
			);
		}
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
