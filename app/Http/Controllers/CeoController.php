<?php

namespace App\Http\Controllers;

use App\Enums\ShiftEnum;
use App\Models\Attendance_shift_time;
use App\Models\Ceo;
use App\Http\Requests\StoreCeoRequest;
use App\Http\Requests\UpdateCeoRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Fines;
use App\Models\Manager;
use App\Models\Pay_rate;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Whoops\Run;

class CeoController extends Controller
{
	public function __construct()
	{
		$this->middleware('ceo');
		$this->model = Manager::query();
		$routeName = Route::currentRouteName();
		$arr = explode('.', $routeName);
		$arr = array_map('ucfirst', $arr);
		$title = implode(' - ', $arr);

		View::share('title', $title);
	}

	/**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
	    $limit = 25;
	    $fields = array('employees.*', 'departments.name as dept_name', 'roles.name as role_name');
	    $data = Employee::where('employees.status','=','1')
		    ->where('departments.status','=','1')
		    ->where('roles.status','=','1')
		    ->leftJoin('departments', 'employees.dept_id', '=', 'departments.id')
		    ->leftJoin('roles', 'employees.role_id', '=', 'roles.id')
		    ->paginate($limit, $fields);

	    return view('ceo.index', [
		    'data' => $data,
	    ]);
    }

	public function time()
	{
		$time = Attendance_shift_time::get();
		$count = Attendance_shift_time::count();
		return view('ceo.time', [
			'time' => $time,
			'count' => $count,
		]);
	}

	public function time_change(Request $request)
	{
		$check_in_start = $request->in_start;
		$check_in_end = $request->in_end;
		$check_out_start = $request->out_start;
		$check_out_end = $request->out_end;
		$id = ShiftEnum::getValue($request->get('name'));
		Attendance_shift_time::Where('id','=',$id)
		->update([
			'check_in_start' => $check_in_start,
			'check_in_end' => $check_in_end,
			'check_out_start' => $check_out_start,
			'check_out_end' => $check_out_end,
		]);
		return Attendance_shift_time::whereId($id)->get();
	}




   public function pay_rate_api(Request $request)
    {
        $dept_id = $request->get('dept_id');
        $pay_rate = Role::query()
        ->leftJoin('departments', 'roles.dept_id', '=', 'departments.id')
        ->select('roles.*', 'departments.name as dept_name')
        ->where('dept_id','=',$dept_id)
        ->get();
        return $pay_rate->append('pay_rate_money')->toArray();
    }

    public function pay_rate_change(Request $request)
    {
        $pay_rate = $request->pay_rate;
        $id = $request->id;
        Role::query()
        ->Where('id','=',$id)
        ->update([
            'pay_rate' => $pay_rate,
        ]);
        return Role::whereId($id)->get()->append('pay_rate_money')->toArray();
    }


    public function fines_store(Request $request)
    {
        $name = $request->name;
        $fines = $request->fines;
        $deduction = $request->deduction;
        return Fines::create([
            'name' => $name,
            'fines' => $fines,
            'deduction' => $deduction,
        ])->append(['fines_time','deduction_detail'])->toArray();

    }

    public function fines_update(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $fines = $request->fines;
        $deduction = $request->deduction;
        Fines::query()
        ->where('id', $id)
        ->update([
            'name' => $name,
            'fines' => $fines,
            'deduction' => $deduction,
        ]);
        return Fines::whereId($id)->get()->append(['fines_time','deduction_detail'])->toArray();
    }
	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCeoRequest $request
     * @return Response
     */
    public function store(StoreCeoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Ceo $ceo
     * @return Response
     */
    public function show(Ceo $ceo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ceo $ceo
     * @return Response
     */
    public function edit(Ceo $ceo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCeoRequest $request
     * @param Ceo $ceo
     * @return Response
     */
    public function update(UpdateCeoRequest $request, Ceo $ceo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ceo $ceo
     * @return void
     */
    public function destroy(Ceo $ceo)
    {
        //
    }
}
