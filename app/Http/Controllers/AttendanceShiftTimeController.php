<?php

namespace App\Http\Controllers;

use App\Models\Attendance_shiftTime;
use App\Http\Requests\StoreAttendanceShiftTimeRequest;
use App\Http\Requests\UpdateAttendanceShiftTimeRequest;

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
     * @param  \App\Http\Requests\StoreAttendanceShiftTimeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceShiftTimeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance_shiftTime  $attendance_shift_time
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance_shiftTime $attendance_shift_time)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance_shiftTime  $attendance_shift_time
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance_shiftTime $attendance_shift_time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttendanceShiftTimeRequest  $request
     * @param  \App\Models\Attendance_shiftTime  $attendance_shift_time
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceShiftTimeRequest $request, Attendance_shiftTime $attendance_shift_time)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance_shiftTime  $attendance_shift_time
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance_shiftTime $attendance_shift_time)
    {
        //
    }
}
