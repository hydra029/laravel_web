<?php

namespace App\Http\Controllers;

use App\Models\Ceo;
use App\Http\Requests\StoreCeoRequest;
use App\Http\Requests\UpdateCeoRequest;

class CeoController extends Controller
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
     * @param  \App\Http\Requests\StoreCeoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCeoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ceo  $ceo
     * @return \Illuminate\Http\Response
     */
    public function show(Ceo $ceo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ceo  $ceo
     * @return \Illuminate\Http\Response
     */
    public function edit(Ceo $ceo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCeoRequest  $request
     * @param  \App\Models\Ceo  $ceo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCeoRequest $request, Ceo $ceo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ceo  $ceo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ceo $ceo)
    {
        //
    }
}
