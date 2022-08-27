<?php

namespace App\Http\Controllers;

use App\Models\AttendanceShiftTime;

class ApiController extends Controller
{
	public function getShiftTimes()
	{
		return AttendanceShiftTime::get();
	}
}
