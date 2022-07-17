<?php

namespace App\Http\Controllers;

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
			->with([
				'roles',
				'departments' => function ($query) {
					$query->where('id', '=', session('dept_id'));
				}
			])
			->get($fields);
		$id = session('id');
		$attendance = Employee::with('attendance')
			->where('id', '=', $id)
			->where('status', '=', 1)
			->get();
		$dept = Department::all();
		return view('test', ([
			'data' => $data,
			'dept' => $dept,
			'attendance' => $attendance,
			'title' => 'Test'
		]));
	}

	/**
	 * @throws \JsonException
	 * @noinspection PhpMultipleClassDeclarationsInspection
	 */
	public function api(Request $request)
	{
		$s = $request->s;
		$m = $request->m;
		$dept_id = session('dept_id');
		$a = Employee::with(['attendance' => function ($query) use ($s, $m) {
			$query->where('date', '<=', $s)->where('date', '>=', $m);
		}])
			->where('dept_id', '=', $dept_id)
			->where('status', '=', 1)
			->get(['id', 'lname', 'fname']);
		return json_decode($a, false, 512, JSON_THROW_ON_ERROR);
	}

    public function input_avatar(Request $request){
        $path = Storage::disk('public')->putFile('img', $request->file('avatar'));
        $arr['avatar'] = $path;
        return $arr;
    }
}
