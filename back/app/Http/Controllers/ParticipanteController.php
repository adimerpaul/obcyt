<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use App\Http\Requests\StoreParticipanteRequest;
use App\Http\Requests\UpdateParticipanteRequest;
use App\Models\Puntos;

class ParticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Participante::orderBy('id','desc')->get();
    }
    public function credenciales()
    {
        $participantes = Participante::orderBy('id','desc')->get();
        foreach ($participantes as $participante) {
            $path = 'imagenes/'.$participante->foto1;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $participantesMostrar[]=["nombre"=>$participante->nombre1,"fechaNac"=>$participante->fechaNac1,"club"=>$participante->club,"foto"=>$base64];
            if ($participante->nombre2!=null){
                $path = 'imagenes/'.$participante->foto2;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $participantesMostrar[]=["nombre"=>$participante->nombre2,"fechaNac"=>$participante->fechaNac2,"club"=>$participante->club,"foto"=>$base64];
            }

        }
        return $participantesMostrar;
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
     * @param  \App\Http\Requests\StoreParticipanteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParticipanteRequest $request)
    {
        return Participante::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Participante  $participante
     * @return \Illuminate\Http\Response
     */
    public function show($categoria)
    {
        return Puntos::where('categoria', $categoria)->with('user')->with('participante')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Participante  $participante
     * @return \Illuminate\Http\Response
     */
    public function edit(Participante $participante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateParticipanteRequest  $request
     * @param  \App\Models\Participante  $participante
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateParticipanteRequest $request, Participante $participante)
    {
        $participante->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Participante  $participante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Participante $participante)
    {
        //
    }
}
