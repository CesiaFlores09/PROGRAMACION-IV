<?php

namespace App\Http\Controllers;

use App\Models\Consejos;
use Illuminate\Http\Request;

class ConsejosController extends Controller
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

    function conseguirConsejo(Request $request)
    {
        $consejo = Consejos::where('idEspecie', $request->id)->get();
        return $consejo;
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
            'consejo' => 'required|string',
        ]);
        $consejo = Consejos::create($parametros);
        return response()->json(['id' => $consejo->id, 'titulo' => $consejo->titulo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consejos  $consejos
     * @return \Illuminate\Http\Response
     */
    public function show(Consejos $consejos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consejos  $consejos
     * @return \Illuminate\Http\Response
     */
    public function edit(Consejos $consejos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consejos  $consejos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consejos $consejos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consejos  $consejos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consejos $consejos)
    {
        //
    }
}
