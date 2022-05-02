<template>
    <div class="card">
        <div class="card-header center-content">
            <p>Buscar mascotas</p>
            <input type="text" v-model="buscar" placeholder="Buscar..." class="form-control" @keyup="buscarMascota()">
        </div>
        <div class="card-body">
            <div v-for="mascota in mascotas" class="row border-2 border-bottom border-secondary pb-2 rounded center-content hover-container d-flex justify-content-between align-items-center" :key="mascota.id" :class="{'d-none': !mascota.mostrar}">
                <div class="col-md-4 center-content">
                    <p><b>{{ mascota.nombre }}</b></p>
                    <img :src="'storage/imagenes/mascotas/fotos/'+mascota.imagen" alt="" class="img-fluid" style="max-width: 100%;">
                </div>
                <div class="col-md-4">
                    <p><b>Color:</b> {{ mascota.color }}</p>
                    <p><b>Raza:</b> {{ mascota.raza }}</p>
                    <p><b>Edad:</b> {{ mascota.edad }}</p>
                    <p><b>Sexo:</b> {{ mascota.sexo }}</p>
                </div>
                <div class="col-md-4 center-content">
                    <p>Cartilla de Vacunación</p>
                    <img :src="'storage/imagenes/mascotas/cartillas/'+mascota.imagen" alt="" class="img-fluid" style="max-width: 100%;">
                </div>
                <div v-if="mascota.duenio == usuario.id" class="col-md-12 d-flex justify-content-around">
                    <button class="btn btn-primary" @click="editarMascota(mascota)">Editar</button>
                    <button class="btn btn-danger" @click="eliminarMascota(mascota.id)">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import vueSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css'
    export default {
        props: {
            usuario: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                mascotas: [],
                buscar: '',
            }
        },
        components: {
            'v-select': vueSelect
        },
        methods: {
            sincronizar(datos, metodo, url) {
                axios[metodo](url, datos)
                    .then(response => {
                        console.log(response.data);
                        if (metodo != 'delete') {
                            this.mascotas = response.data;

                            this.mascotas.forEach(mascota => {
                                mascota.mostrar = true;
                            });
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            eliminarMascota(id) {
                if (confirm('¿Estas seguro de eliminar esta mascota?')) {
                    this.sincronizar({}, 'delete', '/mascotas/eliminar/' + id);
                    this.mascotas = this.mascotas.filter(mascota => mascota.id != id);
                    this.$
                }
            },
            editarMascota(id) {
                this.$root.$emit('editar-mascota', id);
            },
            buscarMascota() {
                this.mascotas.forEach(mascota => {
                    mascota.mostrar = false;
                });
                this.mascotas.map(mascota => {
                    if (mascota.nombre.toLowerCase().includes(this.buscar.toLowerCase()) ||
                        mascota.color.toLowerCase().includes(this.buscar.toLowerCase()) ||
                        mascota.raza.toLowerCase().includes(this.buscar.toLowerCase()) ||
                        mascota.edad.toLowerCase().includes(this.buscar.toLowerCase()) ||
                        mascota.sexo.toLowerCase().includes(this.buscar.toLowerCase())) 
                    {
                        mascota.mostrar = true;
                    }
                    return mascota;
                });
                this.$forceUpdate();
            }
        },
        mounted() {
            this.sincronizar({}, 'get', '/mascotas/mostrar');
        }
    }
</script>

<style>
.actual {
    fill: #00a8ff;
    stroke: #00a8ff;
}
.hover-container:hover {
    background-color: #b0b0b0;
}
</style>