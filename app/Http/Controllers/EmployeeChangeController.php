<?php

namespace App\Http\Controllers;

use App\Models\Employee_change;
use App\Http\Requests\StoreEmployee_changeRequest;
use App\Http\Requests\UpdateEmployee_changeRequest;

class EmployeeChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployee_changeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployee_changeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee_change  $employee_change
     * @return \Illuminate\Http\Response
     */
    public function show(Employee_change $employee_change)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee_change  $employee_change
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee_change $employee_change)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployee_changeRequest  $request
     * @param  \App\Models\Employee_change  $employee_change
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployee_changeRequest $request, Employee_change $employee_change)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee_change  $employee_change
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee_change $employee_change)
    {
        //
    }
}
