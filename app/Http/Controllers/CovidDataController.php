<?php

namespace App\Http\Controllers;

use App\Models\CovidData;
use App\Http\Requests\StoreCovidDataRequest;
use App\Http\Requests\UpdateCovidDataRequest;

class CovidDataController extends Controller
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
     * @param  \App\Http\Requests\StoreCovidDataRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCovidDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CovidData  $covidData
     * @return \Illuminate\Http\Response
     */
    public function show(CovidData $covidData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CovidData  $covidData
     * @return \Illuminate\Http\Response
     */
    public function edit(CovidData $covidData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCovidDataRequest  $request
     * @param  \App\Models\CovidData  $covidData
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCovidDataRequest $request, CovidData $covidData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CovidData  $covidData
     * @return \Illuminate\Http\Response
     */
    public function destroy(CovidData $covidData)
    {
        //
    }
}
