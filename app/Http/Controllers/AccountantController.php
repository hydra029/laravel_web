<?php

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Models\Accountant;
use App\Http\Requests\StoreAccountantRequest;
use App\Http\Requests\UpdateAccountantRequest;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
use App\Models\Employee;
use App\Models\Fines;
use App\Models\Manager;
use App\Models\Salary;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AccountantController extends Controller
{
	public function __construct()
	{
		$this->middleware('accountant');
		$this->model = Manager::query();
		$routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $arr[1] = explode('_', $arr[1]);
        $arr[1] = array_map('ucfirst', $arr[1]);
        $arr[1] = implode(' ', $arr[1]);
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
        $date = date('Y-m-d');
        $data = Attendance::with('shifts')
            ->where('emp_id', '=', session('id'))
            ->where('date', '=', $date)
            ->where('emp_role', '=', session('level'))
            ->get();
        return view('accountants.index', [
            'data' => $data,
        ]);
	}

	public function salary(): Renderable
	{
		return view('accountants.salary');
	}

	public function attendance_history(): Renderable
	{
		return view('accountants.attendance_history');
	}

    public function history_api(Request $request): array
    {
        $f = $request->f;
        $l = $request->l;
	    $arr[] = AttendanceShiftTime::get();
        $arr[] = Attendance::query()
            ->where('date', '<=', $l)
            ->where('date', '>=', $f)
            ->where('emp_id', '=', session('id'))
            ->where('emp_role', '=', session('level'))
            ->get();
        return $arr;
    }

    public function checkin(Request $request): RedirectResponse
    {
        Attendance::where('emp_id', '=', session('id'))
            ->where('emp_role', '=', EmpRoleEnum::ACCOUNTANT)
            ->where('date','=', date('Y-m-d'))
            ->where('shift','=', $request->get('shift'))
            ->update(['check_in' => date('H:i')]);
        session()->flash('noti', [
            'heading' => 'Check in successfully',
            'text' => 'You\'ve checked in shift ' . $request->get('shift') . ' successfully',
            'icon' => 'success',
        ]);

        return redirect()->route('accountants.index');
    }

    public function checkout(Request $request): RedirectResponse
    {
        Attendance::where('emp_id', '=', session('id'))
            ->where('emp_role', '=', EmpRoleEnum::ACCOUNTANT)
            ->where('date','=', date('Y-m-d'))
            ->where('shift','=', $request->get('shift'))
            ->update(['check_out' => date('H:i')]);
        session()->flash('noti', [
            'heading' => 'Check out successfully',
            'text' => 'You\'ve checked out shift ' . $request->get('shift') . ' successfully',
            'icon' => 'success',
        ]);

        return redirect()->route('accountants.index');
    }

    public function salary_api(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $salary = Salary::query()->with('emp')
        ->where('month', $month)
        ->where('year', $year)
        ->get()
        ->append(['salary_money','deduction_detail','pay_rate_money','bounus_salary_over_work_day']);
        return $salary;
    }

    public function salary_detail(Request $request)
    {
        $id = $request->id;
        $dept_name = $request->dept_name;
        $role_name = $request->role_name;
        $month = $request->month;
        $year = $request->year;
        $fines = Fines::query()->get()->append('deduction_detail');
        $salary = Salary::query()->with('emp')
        ->where('emp_id', $id)
        ->where('month', $month)
        ->where('year', $year)
        ->where('dept_name', $dept_name)
        ->where('role_name', $role_name)
        ->first()
        ->append(['salary_money','deduction_detail','pay_rate_money','bounus_salary_over_work_day','deduction_late_one_detail','deduction_late_two_detail','deduction_early_one_detail','deduction_early_two_detail','deduction_miss_detail','pay_rate_over_work_day','pay_rate_work_day'])->toArray();
        $arr['salary'] = $salary;
        $arr['fines'] = $fines;
        return $arr;
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
     * @param StoreAccountantRequest $request
     * @return Response
     */
    public function store(StoreAccountantRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Accountant $accountant
     * @return Response
     */
    public function show(Accountant $accountant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Accountant $accountant
     * @return Response
     */
    public function edit(Accountant $accountant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAccountantRequest $request
     * @param Accountant $accountant
     * @return Response
     */
    public function update(UpdateAccountantRequest $request, Accountant $accountant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Accountant $accountant
     * @return Response
     */
    public function destroy(Accountant $accountant)
    {
        //
    }
}
