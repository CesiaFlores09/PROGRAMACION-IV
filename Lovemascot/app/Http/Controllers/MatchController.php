<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Mascotas;
use App\Models\Users;
use App\Models\MascotaActual;
use Illuminate\Http\Request;

class MatchController extends Controller
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
        $mascotaActual = MascotaActual::where('idUsuario', auth()->user()->id)->get();
        $match = new Matches();
        $match->de = $mascotaActual[0]->idMascota;
        $match->para = $request->para;
        $match->estado = 0;
        $match->save();
        return $match;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matches  $matches
     * @return \Illuminate\Http\Response
     */
    public function show(Matches $matches)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matches  $matches
     * @return \Illuminate\Http\Response
     */
    public function edit(Matches $matches)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matches  $matches
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matches $matches)
    {
        $mascotaActual = MascotaActual::where('idUsuario', auth()->user()->id)->get();
        $match = Matches::where('de', $request->de)->where('para', $mascotaActual[0]->idMascota)->update(['estado' => $request->estado]);
        return $match;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matches  $matches
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matches $matches)
    {
        
    }

    public function rechazar(Request $request)
    {
        $mascotaActual = MascotaActual::where('idUsuario', auth()->user()->id)->get();
        $match = Matches::where('de', $request->de)->where('para', $mascotaActual[0]->idMascota)->delete();
        return response()->json(['success' => 'Match eliminado']);
    }

    public function cancelar(Request $request)
    {
        $mascotaActual = MascotaActual::where('idUsuario', auth()->user()->id)->get();
        $match = Matches::where('de', $mascotaActual[0]->idMascota)->where('para', $request->para)->delete();
        return response()->json(['success' => 'Match eliminado']);
    }
}
