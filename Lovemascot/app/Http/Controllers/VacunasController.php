<?php

namespace App\Http\Controllers;

use App\Models\Vacunas;
use Illuminate\Http\Request;

class VacunasController extends Controller
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

    public function vacunas(Request $request)
    {
        $vacunas = Vacunas::where('idEspecie', $request->raza)->get();
        return $vacunas;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vacunas  $vacunas
     * @return \Illuminate\Http\Response
     */
    public function show(Vacunas $vacunas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vacunas  $vacunas
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacunas $vacunas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vacunas  $vacunas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacunas $vacunas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vacunas  $vacunas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacunas $vacunas)
    {
        //
    }
}
