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
        $request['fecha']=now();
        return Puntos::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Puntos  $puntos
     * @return \Illuminate\Http\Response
     */
    public function show($participante_id)
    {
        $puntos = Puntos::where('participante_id', $participante_id)->with('user')->get();
        return $puntos;
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
        $puntos->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Puntos  $puntos
     * @return \Illuminate\Http\Response
     */
    public function destroy($punto_id)
    {
        $punto = Puntos::find($punto_id);
        $punto->delete();
    }
}
