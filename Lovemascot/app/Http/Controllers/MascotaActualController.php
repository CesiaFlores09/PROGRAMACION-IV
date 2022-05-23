<?php

namespace App\Http\Controllers;

use App\Models\MascotaActual;
use Illuminate\Http\Request;

class MascotaActualController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Buscar la mascota actual del usuario
        $mascotaActual = MascotaActual::where('idUsuario', auth()->user()->id)->first();
        if ($mascotaActual) {
            MascotaActual::where('idUsuario', auth()->user()->id)->update(['idMascota' => $request->idMascota]);
            return $mascotaActual;
        } else {
            $mascotaActual = new MascotaActual();
            $mascotaActual->idUsuario = auth()->user()->id;
            $mascotaActual->idMascota = $request->idMascota;
            $mascotaActual->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MascotaActual  $mascotaActual
     * @return \Illuminate\Http\Response
     */
    public function show(MascotaActual $mascotaActual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MascotaActual  $mascotaActual
     * @return \Illuminate\Http\Response
     */
    public function edit(MascotaActual $mascotaActual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MascotaActual  $mascotaActual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MascotaActual $mascotaActual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MascotaActual  $mascotaActual
     * @return \Illuminate\Http\Response
     */
    public function destroy(MascotaActual $mascotaActual)
    {
        //
    }
}
