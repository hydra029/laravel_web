<?php

namespace App\Http\Controllers;

use App\Models\Attendance_shift_time;
use App\Http\Requests\StoreAttendance_shift_timeRequest;
use App\Http\Requests\UpdateAttendance_shift_timeRequest;

class AttendanceShiftTimeController extends Controller
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
     * @param  \App\Http\Requests\StoreAttendance_shift_timeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendance_shift_timeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance_shift_time  $attendance_shift_time
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance_shift_time $attendance_shift_time)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance_shift_time  $attendance_shift_time
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance_shift_time $attendance_shift_time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttendance_shift_timeRequest  $request
     * @param  \App\Models\Attendance_shift_time  $attendance_shift_time
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendance_shift_timeRequest $request, Attendance_shift_time $attendance_shift_time)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance_shift_time  $attendance_shift_time
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance_shift_time $attendance_shift_time)
    {
        //
    }
}
