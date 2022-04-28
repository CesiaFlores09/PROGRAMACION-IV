<?php

namespace App\Http\Controllers;

use App\Models\Mascotas;
use Illuminate\Http\Request;

class MascotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Mascotas::all();
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
        $parametros = $this->validar($request)->only(['nombre', 'raza', 'color', 'edad', 'sexo',]);
        $mascota = Mascotas::create($parametros);
        $imagen = $request->imagen;
        $imagen = explode(',', $imagen);
        $imagenNombre = $mascota->id . '.png';
        $path = 'storage/imagenes/mascotas/fotos/' . $imagenNombre;
        file_put_contents($path, base64_decode($imagen[1]));
        $mascota->imagen = $imagenNombre;
        $mascota->save();
        return response()->json(['id' => $mascota->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mascotas  $mascotas
     * @return \Illuminate\Http\Response
     */
    public function show(Mascotas $mascotas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mascotas  $mascotas
     * @return \Illuminate\Http\Response
     */
    public function edit(Mascotas $mascotas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mascotas  $mascotas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mascotas $mascotas)
    {
        // Si el campo cartilla no esta vacio, se actualizan los demas campos
        if ($request->cartilla != '') {
            $parametros = $request->validate([
                'cartilla' => 'required|string|',
            ]);
            $imagen = $request->imagen;
            $imagen = explode(',', $imagen);
            $imagenNombre = $request->id_mascota.'.png';
            $path = 'storage/imagenes/mascotas/cartillas/'.$imagenNombre;
            file_put_contents($path, base64_decode($imagen[1]));
            $mascota = Mascotas::find($request->id_mascota);
            $mascota->cartilla = $imagenNombre;
            $mascota->save();
            return response()->json(['status' => 'success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mascotas  $mascotas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mascotas $mascotas)
    {
        //
    }

    public function cartilla(Request $request)
    {
        $parametros = $request->validate([
            'imagen' => 'required|string|',
        ]);
        $imagen = $request->imagen;
        $imagen = explode(',', $imagen);
        $imagenNombre = $request->id_mascota.'.png';
        $path = 'storage/imagenes/mascotas/cartillas/'.$imagenNombre;
        file_put_contents($path, base64_decode($imagen[1]));
        $mascota = Mascotas::find($request->id_mascota);
        $mascota->cartilla = $imagenNombre;
        $mascota->save();
        return response()->json(['status' => 'success']);
    }

    public function validar($parameters)
    {
        $this->validate($parameters, [
            'imagen' => 'required|string|',
            'nombre' => 'required|string|max:255',
            'raza' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'edad' => 'required|integer|min:1',
            'sexo' => 'required|string|max:255',
        ]);
        return $parameters;
    }
}
