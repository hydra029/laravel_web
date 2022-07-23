<?php

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Enums\ShiftEnum;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class ManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware('manager');
        $this->model = Manager::query();
        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $arr = array_map('ucfirst', $arr);
        $title = implode(' - ', $arr);

        View::share('title', $title);
    }

    public function index()
    {
        $date = date('Y-m-d');
        $data = Attendance::with('shifts')
            ->where('emp_id', '=', session('id'))
            ->where('date', '=', $date)
            ->where('emp_role', '=', session('level'))
            ->get();
        return view('managers.index', [
            'data' => $data,
        ]);
    }

    public function today_attendance()
    {
        $limit = 10;
        $date = date('Y-m-d');
        $dept_id = session('dept_id');
        $data = Employee::with(['attendance' => function ($query) use ($date) {
            $query->where('date', '=', $date);
        }, 'roles'])
            ->where('dept_id', '=', $dept_id)
            ->where('status', '=', 1)
            ->paginate($limit);
        $shifts = ShiftEnum::getKeys();
        return view('managers.attendance', [
            'data' => $data,
            'num' => 1,
            'shifts' => $shifts,
        ]);
    }

    public function attendance()
    {
        return view('managers.month_attendance');
    }

    public function attendance_api(Request $request): array
    {
        $f = $request->f;
        $l = $request->l;
        return Attendance::with('shifts')
            ->where('date', '<=', $l)
            ->where('date', '>=', $f)
            ->where('emp_id', '=', session('id'))
            ->where('emp_role', '=', session('level'))
            ->get()
            ->toArray();

    }

    public function employee_attendance(): Renderable
    {
        return view('managers.employee_attendance');
    }

    public function employee_api(Request $request)
    {
        $s = $request->s;
        $m = $request->m;
        $dept_id = session('dept_id');
        return Employee::with([
            'attendance' => function ($query) use ($s, $m) {
                $query->where('date', '<=', $s)->where('date', '>=', $m);
            },
            'attendance.shifts'
        ])
            ->where('dept_id', '=', $dept_id)
            ->where('status', '=', 1)
            ->get(['id', 'lname', 'fname']);
    }

    public function checkin(Request $request): RedirectResponse
    {
        Attendance::where('emp_id', '=', session('id'))
            ->where('emp_role', '=', EmpRoleEnum::Manager)
            ->where('date', '=', date('Y-m-d'))
            ->where('shift', '=', $request->get('shift'))
            ->update(['check_in' => date('H:i')]);
        session()->flash('noti', [
            'heading' => 'Check in successfully',
            'text' => 'You\'ve checked in shift ' . $request->get('shift') . ' successfully',
            'icon' => 'success',
        ]);

        return redirect()->route('managers.index');
    }

    public function checkout(Request $request): RedirectResponse
    {
        Attendance::where('emp_id', '=', session('id'))
            ->where('emp_role', '=', EmpRoleEnum::Manager)
            ->where('date', '=', date('Y-m-d'))
            ->where('shift', '=', $request->get('shift'))
            ->update(['check_out' => date('H:i')]);
        session()->flash('noti', [
            'heading' => 'Check out successfully',
            'text' => 'You\'ve checked out shift ' . $request->get('shift') . ' successfully',
            'icon' => 'success',
        ]);

        return redirect()->route('managers.index');
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
     * @param StoreManagerRequest $request
     * @return Response
     */
    public function store(StoreManagerRequest $request): Response
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Manager $manager
     * @return Response
     */
    public function show(Manager $manager): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Manager $manager
     * @return Response
     */
    public function edit(Manager $manager): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateManagerRequest $request
     * @param Manager $manager
     * @return Response
     */
    public function update(UpdateManagerRequest $request, Manager $manager): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Manager $manager
     * @return Response
     */
    public function destroy(Manager $manager): Response
    {
        //
    }
}
