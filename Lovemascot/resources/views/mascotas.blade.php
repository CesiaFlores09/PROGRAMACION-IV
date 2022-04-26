@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- Centrar el contenido del header -->
                <div class="card-header center-content">
                    <p>Registra tu mascota</p>
                    <svg viewBox="0 0 1440 125" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto d-block w-full">
                        <g id="Desktop - 1">
                            <g id="general">
                                <rect id="Rectangle 1" x="10" y="48" width="350" height="30" rx="10" fill="#C4C4C4"/>
                                <circle id="Ellipse 1" cx="465" cy="63" r="41" stroke="#C4C4C4" stroke-width="8"/>
                                <rect id="Rectangle 3" x="1430.01" y="77.9484" width="350" height="30" rx="10" transform="rotate(179.992 1430.01 77.9484)" fill="#C4C4C4"/>
                                <rect id="Rectangle 4" x="569.927" y="48.0734" width="300.074" height="30" rx="10" transform="rotate(-0.00832114 569.927 48.0734)" fill="#C4C4C4"/>
                                <circle id="Ellipse 3" cx="975.003" cy="63.0145" r="41" transform="rotate(179.992 975.003 63.0145)" stroke="#C4C4C4" stroke-width="8"/>
                            </g>
                            <g id="mascota-listo">
                                @if (session('mascota'))
                                    <circle cx="465" cy="63" r="30" fill="green"/>
                                @else
                                    <circle cx="465" cy="63" r="30" fill="#C4C4C4"/>
                                @endif
                            </g>
                            <g id="cartilla-listo">
                                @if (session('cartilla'))
                                    <circle cx="975.003" cy="63.0145" r="30" transform="rotate(179.992 975.003 63.0145)" fill="green"/>
                                @else
                                    <circle cx="975.003" cy="63.0145" r="30" transform="rotate(179.992 975.003 63.0145)" fill="#C4C4C4"/>
                                @endif
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="card-body">
                    @if (session('mascota'))
                        <form method="POST" action="{{ route('mascotas.cartilla') }}">
                        @csrf
                            <div class="row mb-3">
                                <label for="cartilla" class="col-md-4 col-form-label text-md-end">Cartilla</label>

                                <div class="col-md-6">
                                    <input id="cartilla" type="file" class="form-control @error('cartilla') is-invalid @enderror" name="cartilla" value="{{ old('cartilla') }}" required autocomplete="cartilla" autofocus>

                                    <!-- @error('cartilla')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror -->
                                </div>
                            </div>
                    @else
                        <form @submit.prevent="submitForm">
                        @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Nombre</label>

                                <div class="col-md-6">
                                    <input id="name" v-model="nombre" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    <!-- @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror -->
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="raza" class="col-md-4 col-form-label text-md-end">Raza</label>

                                <div class="col-md-6">
                                    <input id="raza" v-model="raza" type="text" class="form-control @error('raza') is-invalid @enderror" name="raza" value="{{ old('raza') }}" required autocomplete="raza" autofocus>

                                    <!-- @error('raza')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror -->
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="color" class="col-md-4 col-form-label text-md-end">Color</label>

                                <div class="col-md-6">
                                    <input id="color" v-model="color" type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color') }}" required autocomplete="color" autofocus>

                                    <!-- @error('color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror -->
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="edad" class="col-md-4 col-form-label text-md-end">Edad</label>

                                <div class="col-md-6">
                                    <input id="edad" v-model="edad" type="text" class="form-control @error('edad') is-invalid @enderror" name="edad" value="{{ old('edad') }}" required autocomplete="edad" autofocus>

                                    <!-- @error('edad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror -->
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="sexo" class="col-md-4 col-form-label text-md-end">Sexo</label>

                                <div class="col-md-6">
                                    <select id="sexo" v-model="sexo" class="form-control @error('sexo') is-invalid @enderror" name="sexo" value="{{ old('sexo') }}" required autocomplete="sexo" autofocus>
                                        <option value="Macho">Macho</option>
                                        <option value="Hembra">Hembra</option>
                                    </select>
                                    
                                    <!-- @error('sexo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror -->
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Continuar
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
