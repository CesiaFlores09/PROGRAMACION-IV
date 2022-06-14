@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="usuario" class="d-none">
                {{Auth::user()}}
            </div>
            <registro-mascota v-bind:from="formularios" ref="registroMascota" v-if="formularios['registroMascota'].mostrar" :usuario="{{ Auth::user() }}"></registro-mascota>
            <mostrar-mascota v-bind:from="formularios" ref="mostrarMascota" v-if="formularios['mostrarMascota'].mostrar" :usuario="{{ Auth::user() }}"></mostrar-mascota>
            <mis-matches v-bind:from="formularios" ref="misMatches" v-if="formularios['misMatches'].mostrar" :usuario="{{ Auth::user() }}"></mis-matches>
            <actualizar-mascota v-bind:from="formularios" ref="actualizarMascota" v-if="formularios['actualizarMascota'].mostrar" :mascota="mascota"></actualizar-mascota>
            <adiestramiento v-bind:from="formularios" ref="adiestramiento" v-if="formularios['adiestramiento'].mostrar" :mascota="mascota"></adiestramiento>
            <cuidados v-bind:from="formularios" ref="cuidados" v-if="formularios['cuidados'].mostrar" :mascota="mascota"></cuidados>
            <nuevo-adiestramiento v-bind:from="formularios" ref="nuevoAdiestramiento" v-if="formularios['nuevoAdiestramiento'].mostrar" :mascota="mascota"></nuevo-adiestramiento>
            <nuevo-cuidado v-bind:from="formularios" ref="nuevoCuidado" v-if="formularios['nuevoCuidado'].mostrar" :mascota="mascota"></nuevo-cuidado>
            <chat v-bind:from="formularios" ref="chat" v-if="formularios['chat'].mostrar" :usuario="{{Auth::user()}}" :match="match"></chat>
        </div>
    </div>
</div>
@endsection
