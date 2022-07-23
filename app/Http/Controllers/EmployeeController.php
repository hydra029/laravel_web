<?php

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Enums\ShiftStatusEnum;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
use App\Models\Employee;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class EmployeeController extends Controller
{

    use ResponseTrait;

    public function __construct()
    {
        $this->middleware('employee');
        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $arr = array_map('ucfirst', $arr);
        $title = implode(' - ', $arr);

        View::share('title', $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory  \Contracts\View\View
     */
    public function index()
    {
        $date = date('Y-m-d');
        $data = Attendance::with('shifts')
            ->where('emp_id', '=', session('id'))
            ->where('date', '=', $date)
            ->where('emp_role', '=', session('level'))
            ->get();
        return view('employees.index', [
            'data' => $data,
        ]);
    }

    public function employee_infor(Request $request)
    {
        $id = $request->get('id');
        return Employee::query()->whereId($id)->first();
    }

    public function attendance(): Renderable
    {
        return view('employees.month_attendance');
    }

    public function attendance_api(Request $request)
    {
        $f = $request->f;
        $l = $request->l;
        return Attendance::with('shifts')
            ->where('date', '<=', $l)
            ->where('date', '>=', $f)
            ->where('emp_id', '=', session('id'))
            ->where('emp_role', '=', session('level'))
            ->get();
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
     * @param StoreEmployeeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
    }

    public function add(): RedirectResponse
    {
        $users = Employee::get('id');
        foreach ($users as $each) {
            $date = date('Y-m-d', mktime(0, 0, 0, 7, 22, 2022));
            for ($i = 1; $i <= 3; $i++) {
                $data = array('emp_id' => $each->id, 'date' => $date, 'shift' => $i);
                Attendance::create($data);
            }
        }
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return void
     */
    public function show(Employee $employee): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Employee $employee
     * @return void
     */
    public function edit(Employee $employee): void
    {
        //
    }

    public function checkin(Request $request): RedirectResponse
    {
        Attendance::where('emp_id', '=', session('id'))
            ->where('emp_role', '=', EmpRoleEnum::Employee)
            ->where('date', '=', date('Y-m-d'))
            ->where('shift', '=', $request->get('shift'))
            ->update(['check_in' => date('H:i')]);
        session()->flash('noti', [
            'heading' => 'Check in successfully',
            'text' => 'You\'ve checked in shift ' . $request->get('shift') . ' successfully',
            'icon' => 'success',
        ]);
        return redirect()->route('employees.index');
    }

    public function checkout(Request $request): RedirectResponse
    {
        Attendance::where('emp_id', '=', session('id'))
            ->where('emp_role', '=', EmpRoleEnum::Employee)
            ->where('date', '=', date('Y-m-d'))
            ->where('shift', '=', $request->get('shift'))
            ->update(['check_out' => date('H:i')]);
        session()->flash('noti', [
            'heading' => 'Check out successfully',
            'text' => 'You\'ve checked out shift ' . $request->get('shift') . ' successfully',
            'icon' => 'success',
        ]);
        return redirect()->route('employees.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEmployeeRequest $request
     * @param Employee $employee
     * @return void
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): void
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return Response
     */
    public function destroy(Employee $employee): Response
    {
        //
    }
}
