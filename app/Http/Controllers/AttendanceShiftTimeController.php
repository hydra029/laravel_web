<?php

namespace App\Http\Controllers;

use App\Models\AttendanceShiftTime;
use Illuminate\Http\Response;
use App\Http\Requests\AttendanceRequest;
use App\Http\Requests\UpdateAttendanceShiftTimeRequest;

class AttendanceShiftTimeController extends Controller
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
     * @param AttendanceRequest $request
     * @return Response
     */
    public function store(AttendanceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param AttendanceShiftTime $attendance_shift_time
     * @return Response
     */
    public function show(AttendanceShiftTime $attendance_shift_time)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AttendanceShiftTime $attendance_shift_time
     * @return Response
     */
    public function edit(AttendanceShiftTime $attendance_shift_time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAttendanceShiftTimeRequest $request
     * @param AttendanceShiftTime $attendance_shift_time
     * @return Response
     */
    public function update(UpdateAttendanceShiftTimeRequest $request, AttendanceShiftTime $attendance_shift_time)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AttendanceShiftTime $attendance_shift_time
     * @return Response
     */
    public function destroy(AttendanceShiftTime $attendance_shift_time)
    {
        //
    }
}
