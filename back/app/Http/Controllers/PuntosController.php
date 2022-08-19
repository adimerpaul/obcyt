<?php

namespace App\Http\Controllers;

use App\Models\Puntos;
use App\Http\Requests\StorePuntosRequest;
use App\Http\Requests\UpdatePuntosRequest;

class PuntosController extends Controller
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
     * @param  \App\Http\Requests\StorePuntosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePuntosRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Puntos  $puntos
     * @return \Illuminate\Http\Response
     */
    public function show(Puntos $puntos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Puntos  $puntos
     * @return \Illuminate\Http\Response
     */
    public function edit(Puntos $puntos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePuntosRequest  $request
     * @param  \App\Models\Puntos  $puntos
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePuntosRequest $request, Puntos $puntos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Puntos  $puntos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Puntos $puntos)
    {
        //
    }
}
