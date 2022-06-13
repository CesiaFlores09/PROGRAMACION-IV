<template>
    <div class="card">
        <div class="card-header center-content" v-if="step <= 1">
            <p>Cuidados</p>
            <!-- <input type="text" v-model="buscar" placeholder="Buscar..." class="form-control" @keyup="buscarMascota()"> -->
        </div>
        <div v-else class="card-header center-content">
            <p>{{ cuidado.titulo }}</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <button class="btn btn-primary" @click="regresar()" v-if="step >= 1">Regresar</button>
                    <button class="btn btn-primary" @click="nuevoCuidado()">Nuevo cuidado</button>
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
                <div v-if="cuidados.length > 0" class="col-sm-6">
                    <div v-for="cuidado in cuidados" class="col-sm-12" :key="cuidado.id">
                        <div class="card hover-container" @click="seleccionarAdiestramiento(cuidado)">
                            <div class="card-body">
                                <h5 class="card-title">{{ cuidado.titulo }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">No hay cuidados para esta tipo de mascota</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-show="step == 2">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body" id="contenedor2">
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
                cuidados: [],
                cuidado: {},
            }
        },
        methods: {
            sincronizar(datos, metodo, url) {
                return axios[metodo](url, datos)
            },
            seleccionarEspecie(especie) {
                this.step = 1;
                this.cuidados = [];
                this.sincronizar({id: especie.id,}, 'post', '/cuidados/mostrar')
                    .then(response => {
                        this.cuidados = response.data;
                        localStorage.setItem('cuidados', JSON.stringify(this.cuidados));
                    });
            },
            seleccionarAdiestramiento(cuidado) {
                this.step = 2;
                this.cuidado = cuidado;
                let el = document.getElementById('contenedor2');
                el.innerHTML = cuidado.consejo;
            },
            regresar() {
                this.step -= 1;
                this.cuidados = this.step == 0 ? [] : this.cuidados;
            },
            nuevoCuidado() {
                this.$root.$emit('open', 'nuevoCuidado');
            },
        },
        mounted() {
            // this.sincronizar({}, 'get', '/especies/mostrar')
            //     .then(response => {
            //         this.especies = response.data;
            //     });
            let especies = JSON.parse(localStorage.getItem('especies'));
            if (especies) {
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