<?php

namespace App\Http\Controllers;

use App\Models\Accountant;
use App\Models\AttendanceShiftTime;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function test()
	{
		$acct = Accountant::pluck('id');
		return view('test', [
			'title' => 'Test'
		]);
	}

	public function attendance_api(Request $request): array
	{
		$dept_id = session('dept_id');
		$s       = $request->s;
		$m       = $request->m;
		$data[]  = AttendanceShiftTime::get();
		return $data;
	}

	public function emp_attendance_api(Request $request): void
	{
		$emp_id = $request->get('id');
		$dept   = $request->get('dept');
		$role   = $request->get('role');
		$month  = date('m', strtotime('last month'));
		$year   = date('Y', strtotime('last month'));
	}
}
