<template>
    <div class="card">
        <div class="card-header center-content">
            <p>Buscar mascotas</p>
            <input type="text" v-model="buscar" placeholder="Buscar..." class="form-control" @keyup="buscarMascota()">
        </div>
        <div class="card-body">
            <div v-for="mascota in mascotas" class="row border-2 border-bottom border-secondary pb-2 rounded center-content hover-container d-flex justify-content-between align-items-center" :key="mascota.id" :class="{'d-none': !mascota.mostrar, 'border border-success': mascota.actual}">
                <div class="row">
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
                    <div class="col-md-4">
                        <div :id="'cartilla'+mascota.id" class="col-md-4">
                            <img :src="mascota.imgcartilla" alt="" class="img-fluid" style="max-width: 100%;">
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div v-if="mascota.duenio == usuario.id" class="col-md-12 d-flex justify-content-around">
                        <button v-if="!mascota.actual" class="btn btn-success" @click="seleccionarMascota(mascota.id)">Seleccionar</button>
                        <button class="btn btn-primary" @click="editarMascota(mascota)">Editar</button>
                        <button class="btn btn-danger" @click="eliminarMascota(mascota.id)">Eliminar</button>
                    </div>
                    <div v-else class="col-md-12 d-flex justify-content-around">
                        <button class="btn btn-primary" @click="match(mascota.id)" v-if="mascota.match == 'sin match'">Enviar Match</button>
                        <button class="btn btn-primary" @click="cancelarMatch(mascota.id)" v-else-if="mascota.match == 'enviado' && mascota.estado == 0">Cancelar Match</button>
                        <button class="btn btn-primary" @click="aceptarMatch(mascota.id)" v-else-if ="mascota.match == 'recibido' && mascota.estado == 0">Aceptar Match</button>
                        <button class="btn btn-danger" @click="rechazarMatch(mascota.id)" v-if="mascota.match == 'recibido' && mascota.estado == 0">Rechazar Match</button>
                        <button class="btn btn-danger" @click="rechazarMatch(mascota.id)" v-else-if="mascota.match == 'recibido' && mascota.estado == 1">Eliminar Match</button>
                        <button class="btn btn-danger" @click="cancelarMatch(mascota.id)" v-else-if="mascota.match == 'enviado' && mascota.estado == 1">Eliminar Match</button>
                    </div>
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

                            this.mascotas.forEach(mascota => {
                                let canva = document.createElement('canvas');
                                canva.width = '300';
                                canva.height = '300';
                                let ctx = canva.getContext('2d');
                                ctx.fillStyle = '#fff';
                                ctx.fillRect(0, 0, 100, 100);
                                ctx.strokeStyle = '#000';
                                ctx.lineWidth = '1';
                                ctx.font = `${(canva.width / mascota.cartilla[i].vacuna.length)}px Arial`;
                                if (mascota.cartilla !== false) {
                                    for (let i = 0; i < mascota.cartilla.length; i++) {
                                        ctx.fillStyle = '#000';
                                        ctx.fillText(`○ ${mascota.cartilla[i].vacuna}`, 20, 20 + (i * 10));
                                    }
                                } else {
                                    ctx.fillText('No tiene cartilla', 20, 20);
                                }
                                img.src = canva.toDataURL();
                                mascota.imgcartilla = img.src;
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
            },
            seleccionarMascota(idMascota) {
                axios.post('/mascotas/actual', {
                    idMascota
                })
                .then(response => {
                    console.log(response.data);
                    this.sincronizar({}, 'get', '/mascotas/mostrar');
                })
                .catch(error => {
                    console.log(error);
                })
            },
            match(para) {
                axios.post('match/enviar', {para})
                .then(response => {
                    console.log(response.data);
                    this.sincronizar({}, 'get', '/mascotas/mostrar');
                })
            },
            cancelarMatch(para) {
                axios.post('match/cancelar', {para})
                .then(response => {
                    console.log(response.data);
                    this.sincronizar({}, 'get', '/mascotas/mostrar');
                })
            },
            aceptarMatch(de) {
                axios.post('match/aceptar', {de, estado: 1})
                .then(response => {
                    console.log(response.data);
                    this.sincronizar({}, 'get', '/mascotas/mostrar');
                })
            },
            rechazarMatch(de) {
                axios.post('match/rechazar', {de})
                .then(response => {
                    console.log(response.data);
                    this.sincronizar({}, 'get', '/mascotas/mostrar');
                })
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