<?php

namespace App\Http\Controllers;

use App\Enums\ShiftEnum;
use App\Http\Requests\StoreAccountantRequest;
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
        $data = Employee::whereStatus(1)
            ->with(['roles', 'departments'])
            ->paginate($limit, $fields);
        return view('ceo.index', ([
            'data' => $data
        ]));
    }

    public function get_infor()
    {
        $id = session('id');
        $data = Ceo::whereId($id)->first();

        $dept = Department::get();
        return view('ceo.profile', [
            'data' => $data,
            'dept' => $dept,
        ]);
    }

    public function time()
    {
        $time = AttendanceShiftTime::get();
        $count = AttendanceShiftTime::count();
        $shifts = ShiftEnum::asArray();
        return view('ceo.time', [
            'time' => $time,
            'count' => $count,
            'shifts' => $shifts,
        ]);
    }

    public function time_save(Request $request): Request
    {
        AttendanceShiftTime::create([
            'id' => $request->get('id'),
            'check_in_start' => $request->get('in_start'),
            'check_in_end' => $request->get('in_end'),
            'check_in_late_1' => $request->get('in_late_1'),
            'check_in_late_2' => $request->get('in_late_2'),
            'check_out_early_1' => $request->get('out_early_1'),
            'check_out_early_2' => $request->get('out_early_2'),
            'check_out_start' => $request->get('out_start'),
            'check_out_end' => $request->get('out_end'),
            'status' => $request->get('status'),
        ]);

//        return AttendanceShiftTime::whereId($request->get('id'))->get();
        return $request;
    }

    public function time_change(Request $request)
    {
        $id = ShiftEnum::getValue($request->get('name'));
        AttendanceShiftTime::whereId($id)
            ->update([
                'check_in_start' => $request->get('in_start'),
                'check_in_end' => $request->get('in_end'),
                'check_in_late_1' => $request->get('in_late_1'),
                'check_in_late_2' => $request->get('in_late_2'),
                'check_out_early_1' => $request->get('out_early_1'),
                'check_out_early_2' => $request->get('out_early_2'),
                'check_out_start' => $request->get('out_start'),
                'check_out_end' => $request->get('out_end'),
            ]);
        return AttendanceShiftTime::whereId($id)->get();
    }

    public function attendance(): Renderable
    {
        return view('ceo.attendance');
    }

    /**
     * @throws \JsonException
     */
    public function attendance_api(Request $request)
    {
        $s = $request->s;
        $m = $request->m;
        $dept_id = $request->dept_id;
        if ($dept_id === 'all') {
            $arr = Employee::with([
                'attendance' => function ($query) use ($s, $m) {
                    $query->where('date', '<=', $s)->where('date', '>=', $m);
                },
                'attendance.shifts'
            ])
                ->where('status', '=', 1)
                ->get(['id', 'lname', 'fname']);
        } else {
            $arr = Employee::with([
                'attendance' => function ($query) use ($s, $m) {
                    $query->where('date', '<=', $s)->where('date', '>=', $m);
                },
                'attendance.shifts'
            ])
                ->where('dept_id', '=', $dept_id)
                ->where('status', '=', 1)
                ->get(['id', 'lname', 'fname']);
        }
        return $arr;
    }

    public function department_api()
    {
        return Department::get();
    }

    public function pay_rate_api(Request $request): JsonResponse
    {
        $dept_id = $request->get('dept_id');
        $data = Role::query()
            ->where('dept_id', '=', $dept_id)
            ->paginate();
        // return $data->append('pay_rate_money');
        foreach ($data as $each) {
            $each->pay_rate_money = $each->pay_rate_money;
        }
        $arr['data'] = $data->getCollection();
        $arr['pagination'] = $data->linkCollection();

        return $this->successResponse($arr);
    }

    public function pay_rate_change(Request $request): array
    {
        $pay_rate = $request->pay_rate;
        $id = $request->id;
        Role::query()
            ->Where('id', '=', $id)
            ->update([
                'pay_rate' => $pay_rate,
            ]);
        return Role::whereId($id)->get()->append('pay_rate_money')->toArray();
    }

    public function role_store(Request $request): array
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
            ->select(['roles.*', 'departments.name as dept_name'])
            ->where('dept_id', '=', $dept_id)
            ->get();
        return $roles->append('pay_rate_money')->toArray();
    }

    public function fines_store(Request $request): array
    {
        $name = $request->name;
        $fines = $request->fines;
        $deduction = $request->deduction;
        return Fines::create([
            'name' => $name,
            'fines' => $fines,
            'deduction' => $deduction,
        ])->append(['fines_time', 'deduction_detail'])->toArray();
    }

    public function fines_update(Request $request): array
    {
        $id = $request->id;
        $name = $request->name;
        $fines = $request->fines;
        $deduction = $request->deduction;
        Fines::query()
            ->where('id', $id)
            ->update([
                'name' => $name,
                'fines' => $fines,
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

    public function import_acct(Request $request)
    {
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls',
        ]);
        $path = $request->file;

        Excel::import(new AccountantsImport, $path);
    }

    public function import_mgr(Request $request)
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

    public function store_emp(StoreEmployeeRequest $storeEmployeeRequest)
    {
        $arr = $storeEmployeeRequest->validated();
        if ($storeEmployeeRequest->file('avatar')) {
            $avatar = $storeEmployeeRequest->file('avatar');
            $avatarName = date('YmdHi') . $avatar->getClientOriginalName();
            $avatar->move(public_path('img'), $avatarName);
            $arr['avatar'] = $avatarName;
        }
        $hashPassword = Hash::make($storeEmployeeRequest->get('password'));
        $arr['password'] = $hashPassword;
        $role_id = $storeEmployeeRequest->get('role_id');
        $role = Role::query()->with('departments')->where('id', $role_id)->get();
        $emp = Employee::query()->create($arr)->append(['full_name', 'date_of_birth', 'gender_name', 'address'])->toArray();
        $data = [$role, $emp];
        return $data;
    }

    public function employee_infor(Request $request)
    {
        $id = $request->get('id');
        $data = Employee::query()->with(['roles', 'departments'])->whereId($id)->get()->append(['full_name', 'date_of_birth', 'gender_name', 'address'])->toArray();
        return $data;
    }

    public function update_emp(StoreEmployeeRequest $storeEmployeeRequest)
    {
        $arr = $storeEmployeeRequest->validated();
        Employee::query()->update($arr);
    }

    public function delete_emp(Request $request)
    {
        $id = $request->get('id');
        Employee::query()->whereId($id)->delete();
        return 'success';
    }

    public function store_acct(StoreAccountantRequest $storeAccountantRequest)
    {
        $arr = $storeAccountantRequest->validated();
        if ($storeAccountantRequest->file('avatar')) {
            $avatar = $storeAccountantRequest->file('avatar');
            $avatarName = date('YmdHi') . $avatar->getClientOriginalName();
            $avatar->move(public_path('img'), $avatarName);
            $arr['avatar'] = $avatarName;
        }
        $hashPassword = Hash::make($storeAccountantRequest->get('password'));
        $arr['password'] = $hashPassword;
        $role_id = $storeAccountantRequest->get('role_id');
        $role = Role::query()->with('departments')->where('id', $role_id)->get();
        $emp = Accountant::query()->create($arr)->append(['full_name', 'date_of_birth', 'gender_name', 'address'])->toArray();
        $data = [$role, $emp];
        return $data;
    }

    public function store_mgr(StoreManagerRequest $storeManagerRequest)
    {
        $arr = $storeManagerRequest->validated();
        if ($storeManagerRequest->file('avatar')) {
            $avatar = $storeManagerRequest->file('avatar');
            $avatarName = date('YmdHi') . $avatar->getClientOriginalName();
            $avatar->move(public_path('img'), $avatarName);
            $arr['avatar'] = $avatarName;
        }
        $hashPassword = Hash::make($storeManagerRequest->get('password'));
        $arr['password'] = $hashPassword;
        $role_id = $storeManagerRequest->get('role_id');
        $role = Role::query()->with('departments')->where('id', $role_id)->get();
        $emp = Manager::query()->create($arr)->append(['full_name', 'date_of_birth', 'gender_name', 'address'])->toArray();
        $data = [$role, $emp];
        return $data;
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
