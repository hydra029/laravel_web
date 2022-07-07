<?php

namespace App\Http\Controllers;

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
		$limit = 25;
		$fields = [
			'id',
			'fname',
			'lname',
			'gender',
			'dob',
			'email',
			'role_id',
			'dept_id',
		];
		$data = Employee::whereStatus(1)
			->with(['roles', 'departments'])
			->paginate($limit, $fields);
		$id = session('id');
		$attendance = Employee::with('attendance')
			->where('id', '=', $id)
			->first();
		return view('test', ([
			'data' => $data,
			'attendance' => $attendance,
			'title' => 'Test'
		]));
	}

	/**
	 * @throws \JsonException
	 */
	public function api()
	{
		$a = Employee::with('attendance')
			->where('id', '=', session('id'))
			->first('id');
		return json_decode($a, false, 512, JSON_THROW_ON_ERROR);
	}
}
