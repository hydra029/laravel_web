<?php

namespace App\Http\Controllers;

use App\Models\Accountant;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function test()
    {
        return view('test', [
            'title' => 'Test'
        ]);
    }

    public function attendance_api(Request $request): array
    {
        $dept_id = $request->dept_id;
        $s = $request->s;
        $m = $request->m;
        if ($dept_id === 'all') {
            $data[] = Manager::with([
                'attendance' => function ($query) use ($s, $m) {
                    $query->where('date', '<=', $s)->where('date', '>=', $m)
                        ->where('emp_role','=','2');
                },
                'attendance.shifts',
                'departments',
            ])
                ->whereNull('deleted_at')
                ->orderBy('dept_id')
                ->get(['id', 'lname', 'fname','dept_id']);
            $data[] = Accountant::with([
                'attendance' => function ($query) use ($s, $m) {
                    $query->where('date', '<=', $s)->where('date', '>=', $m)
                        ->where('emp_role','=','3');
                },
                'attendance.shifts',
                'departments',
            ])
                ->whereNull('deleted_at')
                ->get(['id', 'lname', 'fname','dept_id']);
            $data[] = Employee::with([
                'attendance' => function ($query) use ($s, $m) {
                    $query->where('date', '<=', $s)->where('date', '>=', $m)
                        ->where('emp_role','=','1');
                },
                'attendance.shifts',
                'departments',
            ])
                ->whereNull('deleted_at')
                ->orderBy('dept_id')
                ->get(['id', 'lname', 'fname','dept_id']);
        } else if ($dept_id === '1') {
            $data[] = Accountant::with([
                'attendance' => function ($query) use ($s, $m) {
                    $query->where('date', '<=', $s)->where('date', '>=', $m)
                        ->where('emp_role','=','2');
                },
                'attendance.shifts',
                'departments',
            ])
                ->whereNull('deleted_at')
                ->get(['id', 'lname', 'fname','dept_id']);
        } else {
            $data[] = Manager::with([
                'attendance' => function ($query) use ($s, $m) {
                    $query->where('date', '<=', $s)->where('date', '>=', $m)
                        ->where('emp_role','=','3');
                },
                'attendance.shifts',
                'departments',
            ])
                ->whereNull('deleted_at')
                ->whereDeptId($dept_id)
                ->get(['id', 'lname', 'fname','dept_id']);
            $data[] = Employee::with([
                'attendance' => function ($query) use ($s, $m) {
                    $query->where('date', '<=', $s)->where('date', '>=', $m)
                        ->where('emp_role','=','1');
                },
                'attendance.shifts',
                'departments',
            ])
                ->whereNull('deleted_at')
                ->whereDeptId($dept_id)
                ->get(['id', 'lname', 'fname','dept_id']);
        }

        return $data;
    }

    public function department_api()
    {
        return Department::get();
    }

    public function emp_attendance_api(Request $request)
    {
        $date = $request->get('date');
        $emp_role = $request->get('role');
        $emp_id = $request->get('id');
        return Attendance::with('shifts')
            ->where('date', 'like', "%$date%")
            ->where('emp_role', '=', $emp_role)
            ->where('emp_id', '=', $emp_id)
            ->get();
    }
}
