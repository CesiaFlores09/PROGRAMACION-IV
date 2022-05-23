<template>
    <div class="card">
        <div class="card-header center-content">
            <p>Registra tu mascota</p>
            <svg viewBox="0 0 1440 125" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto d-block w-full">
                <g id="Desktop - 1">
                    <g id="general">
                        <rect id="Rectangle 1" x="10" y="48" width="350" height="30" rx="10" fill="#C4C4C4" style="stroke:none;" :class="{'actual': step >= '1'}"/>
                        <circle id="Ellipse 1" cx="465" cy="63" r="41" stroke="#C4C4C4" stroke-width="8" style="fill:none;" :class="{'actual': step >= '1'}"/>
                        <rect id="Rectangle 4" x="569.927" y="48.0734" width="300.074" height="30" rx="10" transform="rotate(-0.00832114 569.927 48.0734)" fill="#C4C4C4" style="stroke:none;" :class="{'actual': step >= '2'}"/>
                        <circle id="Ellipse 3" cx="975.003" cy="63.0145" r="41" transform="rotate(179.992 975.003 63.0145)" stroke="#C4C4C4" stroke-width="8" style="fill:none;" :class="{'actual': step >= '2'}"/>
                        <rect id="Rectangle 3" x="1430.01" y="77.9484" width="350" height="30" rx="10" transform="rotate(179.992 1430.01 77.9484)" style="stroke:none;" fill="#C4C4C4" :class="{'actual': step >= '3'}"/>
                    </g>
                    <g id="mascota-listo">
                        <circle cx="465" cy="63" r="30" fill="#C4C4C4" style="stroke:none;" :class="{'actual': step >= '2'}"/>
                    </g>
                    <g id="cartilla-listo">
                        <circle cx="975.003" cy="63.0145" r="30" transform="rotate(179.992 975.003 63.0145)" fill="#C4C4C4" style="stroke:none;" :class="{'actual': step >= '2'}"/>
                    </g>
                </g>
            </svg>
        </div>
        <div class="card-body">
            <form v-if="step == '1'" @submit.prevent="siguiente">
                <div class="row mb-3">
                    <label for="imagen" class="col-md-4 col-form-label text-md-end">Imagen</label>

                    <div class="col-md-6">
                        <input id="imagen" type="file" class="form-control" name="imagen" required autofocus @change="mostrarImagen">
                    </div>
                    <div v-if="errors.imagen" class="alert alert-danger col-md-8 fs-6 mx-auto">  
                        <span v-for="error in errors.imagen" :key="error" class="font-weight-bold">{{ error }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <img :src="registro.imagen" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Nombre</label>

                    <div class="col-md-6">
                        <input id="name" v-model="registro.nombre" type="text" class="form-control" name="name" value="" required autocomplete="name" autofocus>
                    </div>
                    <div v-if="errors.nombre" class="alert alert-danger col-md-8 fs-6 mx-auto">  
                        <span v-for="error in errors.nombre" :key="error" class="font-weight-bold pf-1">{{ error }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="raza" class="col-md-4 col-form-label text-md-end">Raza</label>

                    <div class="col-md-6">
                        <v-select v-model="registro.raza" :options="razas" label="raza" placeholder="Seleccione una raza" taggable push-tags></v-select>
                    </div>
                    <div v-if="errors.raza" class="alert alert-danger col-md-8 fs-6 mx-auto">  
                        <span v-for="error in errors.raza" :key="error" class="font-weight-bold">{{ error }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="color" class="col-md-4 col-form-label text-md-end">Color</label>

                    <div class="col-md-6">
                        <input id="color" v-model="registro.color" type="text" class="form-control" name="color" value="" required autocomplete="color" autofocus>
                    </div>
                    <div v-if="errors.color" class="alert alert-danger col-md-8 fs-6 mx-auto">  
                        <span v-for="error in errors.color" :key="error" class="font-weight-bold">{{ error }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="edad" class="col-md-4 col-form-label text-md-end">Edad</label>

                    <div class="col-md-6">
                        <input id="edad" v-model="registro.edad" type="number" class="form-control" name="edad" value="" required autocomplete="edad" autofocus>
                    </div>
                    <div v-if="errors.edad" class="alert alert-danger col-md-8 fs-6 mx-auto">  
                        <span v-for="error in errors.edad" :key="error" class="font-weight-bold">{{ error }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="sexo" class="col-md-4 col-form-label text-md-end">Sexo</label>

                    <div class="col-md-6">
                        <v-select v-model="registro.sexo" :options="sexos" label="nombre" placeholder="Seleccione una opción"></v-select>
                    </div>
                    <div v-if="errors.sexo" class="alert alert-danger col-md-8 fs-6 mx-auto">  
                        <span v-for="error in errors.sexo" :key="error" class="font-weight-bold">{{ error }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Continuar
                        </button>
                    </div>
                </div>
            </form>
            <form v-if="step == '2'" @submit.prevent="terminar">
                <div class="row mb-3">
                    <h3>Cartilla de vacunación</h3>

                    <div class="row" v-for="vacuna in vacunas" :key="vacuna.id">
                        <div class="col-md-4">
                            <label for="vacuna.id" class="col-form-label text-md-right">{{ vacuna.nombre }}</label>
                        </div>
                        <div class="col-md-6">
                            <input key="vacuna.id" id="vacuna.id" type="checkbox" :value="vacuna.id" @change="vacunaSeleccionada(vacuna.id)">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <form class="col-md-12" @submit.prevent="agregarVacuna">
                            <div class="row">
                                <h4 class="mb-3">Agregar vacuna</h4>
                            </div>
                            <div class="row">
                                <input type="text" class="form-control col-md-6" v-model="nuevaVacuna" placeholder="Nombre de la vacuna">
                                <button type="submit" class="btn btn-primary col-md-4">Agregar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <button type="button" class="btn btn-primary" @click="step = '1'">
                            Atrás
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Terminar
                        </button>
                    </div>
                </div>
            </form>
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
                sexos: [
                    { nombre: 'Macho' },
                    { nombre: 'Hembra' }
                ],
                razas: [],
                vacunas: [],
                errors: {},
                registro: {
                    duenio: this.usuario.id,
                    imagen: '',
                    nombre: '',
                    raza: '',
                    color: '',
                    edad: '',
                    sexo: '',
                },
                cartilla: {
                    id_mascota: '',
                    imagen: '',
                },
                step: '1',
                nuevaVacuna: '',
                raza: '',
            }
        },
        components: {
            'v-select': vueSelect
        },
        methods: {
            sincronizar(datos, metodo, url) {
                axios[metodo](url, datos)
                    .then(response => {
                        console.log(response.data, this.step, this.step == '1', this.step == '2');
                        if (this.step == '1') {
                            this.cartilla.id_mascota = response.data.id;
                            this.registro.id = response.data.id;
                            this.step = '2';
                            this.raza = response.data.raza;
                            this.conseguirVacunas(response.data.raza);
                        } else if (this.step == '2') {
                            this.$root.$emit('close', 'registroMascota');
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        this.errors = error.response.data.errors;
                        console.log(this.errors);
                    })
            },
            conseguirVacunas(raza) {
                axios.post('/vacunas', {raza})
                    .then(response => {
                        this.vacunas = response.data;
                        this.vacunas.forEach(vacuna => {
                            vacuna.seleccionada = false;
                        });
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            conseguirRazas() {
                axios.get('/mascotas/razas')
                    .then(response => {
                        this.razas = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            agregarVacuna() {
                this.vacunas.push({nombre: this.nuevaVacuna, id: this.vacunas.length + 1, seleccionada: false});
                this.nuevaVacuna = '';
            },
            mostrarImagen(e) {
                var reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = (e) => {
                    this.registro.imagen = e.target.result;
                }
            },
            siguiente() {
                this.registro.sexo = this.registro.sexo.nombre ? this.registro.sexo.nombre : this.registro.sexo;
                this.registro.raza = this.registro.raza.raza ? this.registro.raza.raza : this.registro.raza;
                if (this.registro.id) {
                    this.sincronizar(this.registro, 'put', 'mascotas/actualizar');
                } else {
                    this.sincronizar(this.registro, 'post', 'mascotas/continuar');
                }
            },
            vacunaSeleccionada(id) {
                this.vacunas.forEach(vacuna => {
                    if (vacuna.id == id) {
                        vacuna.seleccionada = true;
                    }
                });
            },
            terminar() {
                let datos = {
                    raza: this.raza,
                    id_mascota: this.cartilla.id_mascota,
                    vacunas: this.vacunas
                }
                this.sincronizar(datos, 'post', 'mascotas/terminar');
            }
        },
        mounted() {
            console.log('Component mounted.');
            this.conseguirRazas();
        }
    }
</script>

<style>
.actual {
    fill: #00a8ff;
    stroke: #00a8ff;
}
</style>