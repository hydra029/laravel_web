<?php

namespace App\Http\Controllers;

use App\Models\Fines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class FinesController extends Controller
{
	public function __construct()
	{
		$this->middleware('ceo');
		$this->model = new Fines();
		$routeName   = Route::currentRouteName();
		$arr         = explode('.', $routeName);
		$arr         = array_map('ucfirst', $arr);
		$title       = implode(' - ', $arr);

		View::share('title', $title);
	}

	public function index()
	{
		$fines = $this->model::get();
		return view('ceo.fines', [
			'fines' => $fines,
		]);
	}

	public function store(Request $request): array
	{
		$name      = $request->name;
		$fines     = $request->fines;
		$deduction = $request->deduction;
		return $this->model::create([
			                            'id',
			                            'name'      => $name,
			                            'fines'     => $fines,
			                            'deduction' => $deduction,
		                            ])->append(['fines_id', 'fines_time', 'deduction_detail'])->toArray();
	}

	public function update(Request $request): array
	{
		$id        = $request->id;
		$name      = $request->name;
		$fines     = $request->fines;
		$deduction = $request->deduction;
		$this->model::where('id', $id)
			->update([
				         'name'      => $name,
				         'fines'     => $fines,
				         'deduction' => $deduction,
			         ]);
		return $this->model::whereId($id)->get()->append(['fines_time', 'deduction_detail'])->toArray();
	}
}
