<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Http\Requests\StoreCheckRequest;
use App\Http\Requests\UpdateCheckRequest;
use Illuminate\Http\Response;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCheckRequest $request
     * @return Response
     */
    public function store(StoreCheckRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Attendance $check
     * @return void
     */
    public function show(Attendance $check)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Attendance $check
     * @return void
     */
    public function edit(Attendance $check)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCheckRequest $request
     * @param Attendance $check
     * @return Response
     */
    public function update(UpdateCheckRequest $request, Attendance $check)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Attendance $check
     * @return Response
     */
    public function destroy(Attendance $check)
    {
        //
    }
}
