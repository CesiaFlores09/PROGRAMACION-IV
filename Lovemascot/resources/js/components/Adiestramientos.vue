<template>
    <div class="card">
        <div class="card-header center-content" v-if="step <= 1">
            <p>Adiestramientos</p>
            <!-- <input type="text" v-model="buscar" placeholder="Buscar..." class="form-control" @keyup="buscarMascota()"> -->
        </div>
        <div v-else class="card-header center-content">
            <p>{{ adiestramiento.titulo }}</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <button class="btn btn-primary" @click="regresar()" v-if="step >= 1">Regresar</button>
                    <button class="btn btn-primary" @click="nuevoAdiestramiento()">Nuevo adiestramiento</button>
                </div>
            </div>
            <div class="row" v-if="step == 0">
                <div v-for="especie in especies" class="col-sm-4 mb-2" :key="especie.id">
                    <div class="card hover-container" @click="seleccionarEspecie(especie)">
                        <div class="card-body">
                            <h5 class="card-title">{{ especie.nombre }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="step == 1">
                <div v-if="adiestramientos.length > 0">
                    <div v-for="adiestramiento in adiestramientos" class="col-sm-6" :key="adiestramiento.id">
                        <div class="card hover-container" @click="seleccionarAdiestramiento(adiestramiento)">
                            <div class="card-body">
                                <h5 class="card-title">{{ adiestramiento.titulo }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">No hay adiestramientos para esta tipo de mascota</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-show="step == 2">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body" id="contenedor1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script async defer>
    export default {
        data() {
            return {
                step: 0,
                especies: [],
                adiestramientos: [],
                adiestramiento: {},
            }
        },
        methods: {
            sincronizar(datos, metodo, url) {
                return axios[metodo](url, datos)
            },
            seleccionarEspecie(especie) {
                this.step = 1;
                this.adiestramientos = [];
                this.sincronizar({id: especie.id}, 'post', '/adiestramiento/mostrar')
                        .then(response => {
                            this.adiestramientos = response.data;
                            localStorage.setItem('adiestramientos', JSON.stringify(response.data));
                        });
            },
            seleccionarAdiestramiento(adiestramiento) {
                this.step = 2;
                this.adiestramiento = adiestramiento;
                let el = document.getElementById('contenedor1');
                el.innerHTML = adiestramiento.descripcion;
            },
            regresar() {
                this.step -= 1;
                this.adiestramientos = this.step == 0 ? [] : this.adiestramientos;
            },
            nuevoAdiestramiento() {
                this.$root.$emit('open', 'nuevoAdiestramiento');
            },
        },
        mounted() {
            // this.sincronizar({}, 'get', '/especies/mostrar')
            //     .then(response => {
            //         this.especies = response.data;
            //     });
            let especies = JSON.parse(localStorage.getItem('especies'));
            if (especies || especies == '[]') {
                this.especies = especies;
            } else {
                this.sincronizar({}, 'get', '/especies/mostrar')
                    .then(response => {
                        this.especies = response.data;
                        localStorage.setItem('especies', JSON.stringify(response.data));
                    });
            }
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