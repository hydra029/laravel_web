<?php

namespace App\Http\Controllers;

use App\Models\Pay_rate_change;
use App\Http\Requests\StorePay_rate_changeRequest;
use App\Http\Requests\UpdatePay_rate_changeRequest;

class PayRateChangeController extends Controller
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
     * @param  \App\Http\Requests\StorePay_rate_changeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePay_rate_changeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pay_rate_change  $pay_rate_change
     * @return \Illuminate\Http\Response
     */
    public function show(Pay_rate_change $pay_rate_change)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pay_rate_change  $pay_rate_change
     * @return \Illuminate\Http\Response
     */
    public function edit(Pay_rate_change $pay_rate_change)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePay_rate_changeRequest  $request
     * @param  \App\Models\Pay_rate_change  $pay_rate_change
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePay_rate_changeRequest $request, Pay_rate_change $pay_rate_change)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pay_rate_change  $pay_rate_change
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pay_rate_change $pay_rate_change)
    {
        //
    }
}
