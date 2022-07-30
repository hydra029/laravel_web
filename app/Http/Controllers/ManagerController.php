<?php

namespace App\Http\Controllers;

use App\Enums\EmpRoleEnum;
use App\Enums\ShiftEnum;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use App\Models\Accountant;
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
        $arr[1] = explode('_', $arr[1]);
        $arr[1] = array_map('ucfirst', $arr[1]);
        $arr[1] = implode(' ', $arr[1]);
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

    public function add(): RedirectResponse
    {
        $data = [];
        $shift_11 = [];
        $shift_12 = [];
        $shift_21 = [];
        $shift_22 = [];
        $shift_31 = [];
        $shift_32 = [];

        for ($i = 0; $i <= 59; $i++) {
            if ($i < 10) {
                $a = '0' . $i;
            } else {
                $a = $i;
            }
            $shift11 = '07:' . $a;
            $shift12 = '11:' . $a;
            $shift32 = '21:' . $a;
            $shift_11[] = $shift11;
            $shift_12[] = $shift12;
            $shift_32[] = $shift32;
        }
        for ($i = 31; $i <= 59; $i++) {
            $shift21 = '13:' . $a;
            $shift22 = '17:' . $a;
            $shift31 = '17:' . $a;
            $shift_21[] = $shift21;
            $shift_22[] = $shift22;
            $shift_31[] = $shift31;
        }
        for ($i = 0; $i <= 30; $i++) {
            if ($i < 10) {
                $a = '0' . $i;
            } else {
                $a = $i;
            }
            $shift21 = '14:' . $a;
            $shift22 = '18:' . $a;
            $shift31 = '18:' . $a;
            $shift_21[] = $shift21;
            $shift_22[] = $shift22;
            $shift_31[] = $shift31;
        }
        for ($i = 1; $i <= 30; $i++) {
            if ($i < 10) {
                $a = '0' . $i;
            } else {
                $a = $i;
            }
            $date = '2022-07-' . $a;

            for ($j = 1; $j <= 40; $j++) {
                $start1 = $shift_11[array_rand($shift_11)];
                $end1 = $shift_12[array_rand($shift_12)];
                $start2 = $shift_21[array_rand($shift_21)];
                $end2 = $shift_22[array_rand($shift_22)];
                $start3 = $shift_31[array_rand($shift_31)];
                $end3 = $shift_32[array_rand($shift_32)];
                $data[] = [
                    'date' => $date,
                    'emp_id' => $j,
                    'emp_role' => 1,
                    'shift' => 1,
                    'check_in' => $start1,
                    'check_out' => $end1,
                ];
                $data[] = [
                    'date' => $date,
                    'emp_id' => $j,
                    'emp_role' => 1,
                    'shift' => 2,
                    'check_in' => $start2,
                    'check_out' => $end2,
                ];
                $data[] = [
                    'date' => $date,
                    'emp_id' => $j,
                    'emp_role' => 1,
                    'shift' => 3,
                    'check_in' => $start3,
                    'check_out' => $end3,
                ];
            }
            for ($j = 1; $j <= 5; $j++) {
                $start1 = $shift_11[array_rand($shift_11)];
                $end1 = $shift_12[array_rand($shift_12)];
                $start2 = $shift_21[array_rand($shift_21)];
                $end2 = $shift_22[array_rand($shift_22)];
                $start3 = $shift_31[array_rand($shift_31)];
                $end3 = $shift_32[array_rand($shift_32)];
                $data[] = [
                    'date' => $date,
                    'emp_id' => $j,
                    'emp_role' => 2,
                    'shift' => 1,
                    'check_in' => $start1,
                    'check_out' => $end1,
                ];
                $data[] = [
                    'date' => $date,
                    'emp_id' => $j,
                    'emp_role' => 2,
                    'shift' => 2,
                    'check_in' => $start2,
                    'check_out' => $end2,
                ];
                $data[] = [
                    'date' => $date,
                    'emp_id' => $j,
                    'emp_role' => 2,
                    'shift' => 3,
                    'check_in' => $start3,
                    'check_out' => $end3,
                ];
            }
            for ($j = 1; $j <= 5; $j++) {
                $start1 = $shift_11[array_rand($shift_11)];
                $end1 = $shift_12[array_rand($shift_12)];
                $start2 = $shift_21[array_rand($shift_21)];
                $end2 = $shift_22[array_rand($shift_22)];
                $start3 = $shift_31[array_rand($shift_31)];
                $end3 = $shift_32[array_rand($shift_32)];
                $data[] = [
                    'date' => $date,
                    'emp_id' => $j,
                    'emp_role' => 3,
                    'shift' => 1,
                    'check_in' => $start1,
                    'check_out' => $end1,
                ];
                $data[] = [
                    'date' => $date,
                    'emp_id' => $j,
                    'emp_role' => 3,
                    'shift' => 2,
                    'check_in' => $start2,
                    'check_out' => $end2,
                ];
                $data[] = [
                    'date' => $date,
                    'emp_id' => $j,
                    'emp_role' => 3,
                    'shift' => 3,
                    'check_in' => $start3,
                    'check_out' => $end3,
                ];
            }
        }

//        dd($data);
        Attendance::insert($data);
        return redirect()->route('managers.index');
    }

    public
    function today_attendance()
    {
        $limit = 10;
        $date = date('Y-m-d');
        $dept_id = session('dept_id');
        $data = Employee::with(['attendance' => function ($query) use ($date) {
            $query->where('date', '=', $date);
        }, 'roles'])
            ->where('dept_id', '=', $dept_id)
            ->whereNull('deleted_at')
            ->paginate($limit);
        $shifts = ShiftEnum::getArrayView();
        return view('managers.today_attendance', [
            'data' => $data,
            'num' => 1,
            'shifts' => $shifts,
        ]);
    }

    public
    function attendance_history()
    {
        return view('managers.attendance_history');
    }

    public
    function attendance_api(Request $request)
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

    public
    function employee_attendance(): Renderable
    {
        return view('managers.employee_attendance');
    }

    public
    function employee_api(Request $request)
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
            ->whereNull('deleted_at')
            ->get(['id', 'lname', 'fname']);
    }

    public
    function emp_attendance_api(Request $request)
    {
        $date = $request->get('date');
        $emp_role = 1;
        $emp_id = $request->get('id');
        return Attendance::with('shifts')
            ->where('date', 'like', "%$date%")
            ->where('emp_role', '=', $emp_role)
            ->where('emp_id', '=', $emp_id)
            ->get();
    }

    public
    function checkin(Request $request): RedirectResponse
    {
        Attendance::where('emp_id', '=', session('id'))
            ->where('emp_role', '=', EmpRoleEnum::MANAGER)
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

    public
    function checkout(Request $request): RedirectResponse
    {
        Attendance::where('emp_id', '=', session('id'))
            ->where('emp_role', '=', EmpRoleEnum::MANAGER)
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
    public
    function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreManagerRequest $request
     * @return Response
     */
    public
    function store(StoreManagerRequest $request): Response
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Manager $manager
     * @return Response
     */
    public
    function show(Manager $manager): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Manager $manager
     * @return Response
     */
    public
    function edit(Manager $manager): Response
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
    public
    function update(UpdateManagerRequest $request, Manager $manager): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Manager $manager
     * @return Response
     */
    public
    function destroy(Manager $manager): Response
    {
        //
    }
}
