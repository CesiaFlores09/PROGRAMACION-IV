<?php

namespace App\Http\Controllers;

use App\Models\Mascotas;
use App\Models\Especies;
use App\Models\MascotaActual;
use App\Models\Cartillas;
use App\Models\Vacunas;
use App\Models\DetalleCartillas;
use App\Models\Matches;
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
        $mascotas = Mascotas::select('mascotas.*', 'Especies.nombre as raza')
            ->join('Especies', 'mascotas.raza', '=', 'Especies.id')
            ->get();
        $actual = MascotaActual::where('idUsuario', auth()->user()->id)->get();
        if (count($actual) > 0) {
            for ($i = 0; $i < count($mascotas); $i++) {
                for ($j = 0; $j < count($actual); $j++) {
                    if ($mascotas[$i]->id == $actual[$j]->idMascota) {
                        $mascotas[$i]->actual = true;
                    } else {
                        $mascotas[$i]->actual = false;
                    }
                }
            }
        } else {
            for ($i = 0; $i < count($mascotas); $i++) {
                $mascotas[$i]->actual = false;
            }
        }
        $match = Matches::where('de', $actual[0]->idMascota)->orWhere('para', $actual[0]->idMascota)->get();
        for ($i = 0; $i < count($mascotas); $i++) {
            $mascotas[$i]->match = 'sin match';
            $mascotas[$i]->estado = 0;
            if (count($match) > 0) {
                for ($j = 0; $j < count($match); $j++) {
                    if ($mascotas[$i]->id == $match[$j]->de) {
                        $mascotas[$i]->match = 'recibido';
                        if ($match[$j]->estado == 0) {
                            $mascotas[$i]->estado = 0;
                        } else {
                            $mascotas[$i]->estado = 1;
                        }
                    } else if ($mascotas[$i]->id == $match[$j]->para) {
                        $mascotas[$i]->match = 'enviado';
                        if ($match[$j]->estado == 0) {
                            $mascotas[$i]->estado = 0;
                        } else {
                            $mascotas[$i]->estado = 1;
                        }
                    }
                }
            }
        }
        if (count($mascotas) > 0) {
            for ($i = 0; $i < count($mascotas); $i++) {
                $cartilla = Cartillas::where('idMascota', $mascotas[$i]->id)->first();
                if ($cartilla) {
                    $detalles = DetalleCartillas::select('detalle_cartillas.*', 'vacunas.nombre as vacuna')
                    ->join('vacunas', 'detalle_cartillas.idVacuna', '=', 'vacunas.id')
                    ->where('idCartilla', $cartilla->id)
                    ->get();
                    $mascotas[$i]->cartilla = $detalles;

                } else {
                    $mascotas[$i]->cartilla = false;
                }
            }
        }
        return $mascotas;
    }

    public function razas()
    {
        return Especies::select('nombre as raza')->orderBy('nombre')->get();
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
        $parametros = $this->validar($request)->only(['duenio', 'nombre', 'raza', 'color', 'edad', 'sexo',]);
        $especie = Especies::where('nombre', $parametros['raza'])->first();
        if ($especie) {
            $parametros['raza'] = $especie->id;
        } else {
            $especie = Especies::create(['nombre' => $parametros['raza']]);
            $parametros['raza'] = $especie->id;
        }
        $mascota = Mascotas::create($parametros);
        $imagen = $request->imagen;
        $imagen = explode(',', $imagen);
        $imagenNombre = $mascota->id . '.png';
        $path = 'storage/imagenes/mascotas/fotos/' . $imagenNombre;
        file_put_contents($path, base64_decode($imagen[1]));
        $mascota->imagen = $imagenNombre;
        $mascota->save();
        $cartilla = Cartillas::create(['idMascota' => $mascota->id]);
        return response()->json(['id' => $mascota->id, 'raza' => $mascota->raza]);
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

    public function actualizar(Request $request)
    {
        $mascota = Mascotas::find($request->id);
        $mascota->nombre = $request->nombre;
        $especie = Especies::where('nombre', $request->raza)->first();
        if ($especie) {
            $mascota->raza = $especie->id;
        } else {
            $especie = Especies::create(['nombre' => $request->raza]);
            $mascota->raza = $especie->id;
        }
        $mascota->color = $request->color;
        $mascota->edad = $request->edad;
        $mascota->sexo = $request->sexo;
        $imagen = $request->imagen;
        $imagen = explode(',', $imagen);
        $imagenNombre = $request->id.'.png';
        $path = 'storage/imagenes/mascotas/fotos/'.$imagenNombre;
        file_put_contents($path, base64_decode($imagen[1]));
        $mascota->save();
        return response()->json(['id' => $mascota->id, 'raza' => $mascota->raza]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mascotas  $mascotas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mascotas $mascotas, $id)
    {
        $mascota = Mascotas::find($id);
        $cartilla = Cartillas::where('idMascota', $id)->first();
        if ($cartilla) {
            $detalles = DetalleCartillas::where('idCartilla', $cartilla->id)->get();
            if ($detalles) {
                DetalleCartillas::where('idCartilla', $cartilla->id)->delete();
            }
            Cartillas::where('idMascota', $id)->delete();
        }
        $mascotaActual = MascotaActual::where('idUsuario', auth()->user()->id)->first();
        if ($mascotaActual->idMascota == $id) {
            MascotaActual::where('idUsuario', auth()->user()->id)->delete();
        }
        $matches = Matches::where('de', $id)->orWhere('para', $id)->get();
        if ($matches) {
            foreach ($matches as $match) {
                $match->delete();
            }
        }
        $path = 'storage/imagenes/mascotas/fotos/' . $mascota->imagen;
        if (file_exists($path)) {
            unlink($path);
        }
        $mascota->delete();
        return response()->json(['status' => 'success']);
    }

    public function cartilla(Request $request)
    {
        $vacunasEnviadas = $request->vacunas;
        for ($i = 0; $i < count($vacunasEnviadas); $i++) {
            $vacuna = Vacunas::where('idEspecie', $request->raza)->where('nombre', $vacunasEnviadas[$i]['nombre'])->first();
            if (!$vacuna) {
                $vacuna = Vacunas::create(['idEspecie' => $request->raza, 'nombre' => $vacunasEnviadas[$i]['nombre']]);
                $vacunasEnviadas[$i]['id'] = $vacuna->id;
            }
        }
        $cartilla = Cartillas::where('idMascota', $request->id_mascota)->first();
        $detalles = DetalleCartillas::where('idCartilla', $cartilla->id)->get();
        for ($i = 0; $i < count($vacunasEnviadas); $i++) {
            if ($vacunasEnviadas[$i]['seleccionada'] == true) {
                $detalle = DetalleCartillas::where('idCartilla', $cartilla->id)->where('idVacuna', $vacunasEnviadas[$i]['id'])->first();
                if (!$detalle) {
                    DetalleCartillas::create(['idCartilla' => $cartilla->id, 'idVacuna' => $vacunasEnviadas[$i]['id']]);
                }
            }
        }
        $mascotaActual = new MascotaActual();
        $mascotaActual->idUsuario = auth()->user()->id;
        $mascotaActual->idMascota = $request->id_mascota;
        $mascotaActual->save();
        return response()->json(['status' => 'success']);
    }

    public function validar($parameters)
    {
        $this->validate($parameters, [
            'duenio' => 'integer|required',
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
