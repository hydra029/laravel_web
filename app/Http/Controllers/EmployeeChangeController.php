<?php

namespace App\Http\Controllers;

use App\Models\Employee_change;
use App\Http\Requests\StoreEmployee_changeRequest;
use App\Http\Requests\UpdateEmployee_changeRequest;
use Illuminate\Http\Response;

class EmployeeChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @param StoreEmployee_changeRequest $request
     * @return Response
     */
    public function store(StoreEmployee_changeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Employee_change $employee_change
     * @return Response
     */
    public function show(Employee_change $employee_change)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Employee_change $employee_change
     * @return Response
     */
    public function edit(Employee_change $employee_change)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEmployee_changeRequest $request
     * @param Employee_change $employee_change
     * @return Response
     */
    public function update(UpdateEmployee_changeRequest $request, Employee_change $employee_change)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee_change $employee_change
     * @return Response
     */
    public function destroy(Employee_change $employee_change)
    {
        //
    }
}
