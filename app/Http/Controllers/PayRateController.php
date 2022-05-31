<?php

namespace App\Http\Controllers;

use App\Models\Pay_rate;
use App\Http\Requests\StorePay_rateRequest;
use App\Http\Requests\UpdatePay_rateRequest;

class PayRateController extends Controller
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
     * @param  \App\Http\Requests\StorePay_rateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePay_rateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pay_rate  $pay_rate
     * @return \Illuminate\Http\Response
     */
    public function show(Pay_rate $pay_rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pay_rate  $pay_rate
     * @return \Illuminate\Http\Response
     */
    public function edit(Pay_rate $pay_rate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePay_rateRequest  $request
     * @param  \App\Models\Pay_rate  $pay_rate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePay_rateRequest $request, Pay_rate $pay_rate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pay_rate  $pay_rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pay_rate $pay_rate)
    {
        //
    }
}
