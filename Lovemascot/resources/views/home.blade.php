@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <registro-mascota v-bind:from="formularios" ref="registroMascota" v-if="formularios['registroMascota'].mostrar"></registro-mascota>
        </div>
    </div>
</div>
@endsection