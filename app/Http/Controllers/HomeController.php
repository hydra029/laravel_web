<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Attendance_shift_time;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function test(): Renderable
    {
	    $shifts = Attendance_shift_time::get();
	    foreach ($shifts as $shift) {
		    $check_in_start = strtotime($shift->check_in_start);
		    echo date('h:i',$check_in_start);
		    $check_in_end = $shift->check_in_end;
		    $check_out_start = $shift->check_out_start;
		    $check_out_end = $shift->check_out_end;
		    $id = $shift->id;
			echo date('h:i',$check_in_start) . ' - ';
	    }
	    exit;
//	    Attendance::query()
//		    ->update(['status' => 1]);
    }
}
