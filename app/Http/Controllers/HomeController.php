<?php

namespace App\Http\Controllers;

use App\Models\AttendanceShiftTime;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

	/**
	 * Show the application dashboard.
	 *
	 * @return Renderable
	 */
	public function test(): Renderable
	{

		return view('test',[
			'title' => 'Test'
		]);
	}

	public function api(Request $request)
	{
		$s = $request->s;
		$m = $request->m;
		$dept_id = session('dept_id');
		return Employee::with([
			'attendance' => function ($query) use ($s, $m) {
				$query->where('date', '<=', $s)->where('date', '>=', $m);
			},
			'attendance.shift'
		])
			->where('dept_id', '=', $dept_id)
			->where('status', '=', 1)
			->get(['id', 'lname', 'fname']);
	}

    public function input_avatar(Request $request){
        $path = Storage::disk('public')->putFile('img', $request->file('avatar'));
        $arr['avatar'] = $path;
        return $arr;
    }
}
