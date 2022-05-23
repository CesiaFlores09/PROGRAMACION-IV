<?php

namespace App\Http\Controllers;

use App\Models\Adiestramiento;
use Illuminate\Http\Request;

class AdiestramientosController extends Controller
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

    function conseguirAdiestramiento(Request $request)
    {
        $adiestramiento = Adiestramiento::where('idEspecie', $request->id)->get();
        return $adiestramiento;
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
        $parametros = Request()->validate([
            'idEspecie' => 'required|integer',
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
        ]);
        $adiestramiento = Adiestramiento::create($parametros);
        return response()->json(['id' => $adiestramiento->id, 'titulo' => $adiestramiento->titulo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adiestramiento  $adiestramiento
     * @return \Illuminate\Http\Response
     */
    public function show(Adiestramiento $adiestramiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adiestramiento  $adiestramiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Adiestramiento $adiestramiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adiestramiento  $adiestramiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Adiestramiento $adiestramiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adiestramiento  $adiestramiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adiestramiento $adiestramiento)
    {
        //
    }
}
