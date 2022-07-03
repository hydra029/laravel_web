<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{

	/**
	 * Show the application dashboard.
	 *
	 * @return Renderable
	 */
	public function test(): Renderable
	{
//		$data = Employee::find(8)->roles()->select('lname')->get();
		$data = Employee::with(['roles','departments'])->where('status', '=', '1')->paginate(5);
		// dd($data->toArray());
		return view('test',([
			'title' => 'Test',
			'data' => $data,
		]));
	}
}
