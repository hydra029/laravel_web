<?php

namespace App\Http\Controllers;

use App\Models\AttendanceShiftTime;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{


    public function test()
    {
        $dept_id = session('dept_id');
        $data = Employee::with(['attendance','attendance.shift'])
            ->where('dept_id', '=', 2)
            ->where('status', '=', 1)
            ->get(['id', 'lname', 'fname']);
        dd($data);
        return view('test', [
            'data' => $data,
            'title' => 'Test'
        ]);
    }

    public function api(Request $request)
    {
        $s = $request->s;
        $m = $request->m;
        $dept_id = session('dept_id');
        $data = Employee::with([
            'attendance' => function ($query) use ($s, $m) {
                $query->where('date', '<=', $s)->where('date', '>=', $m);
            },
            'attendance.shift'
        ])
            ->where('dept_id', '=', $dept_id)
            ->where('status', '=', 1)
            ->get(['id', 'lname', 'fname']);
        return view('test', [
            'data' => $data
        ]);
    }

    public function input_avatar(Request $request)
    {
        $path = Storage::disk('public')->putFile('img', $request->file('avatar'));
        $arr['avatar'] = $path;
        return $arr;
    }
}
