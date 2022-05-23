<template>
    <div class="card">
        <div class="card-header center-content">
            <p>Cuidados</p>
            <!-- <input type="text" v-model="buscar" placeholder="Buscar..." class="form-control" @keyup="buscarMascota()"> -->
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-1">
                    <button class="btn btn-primary" @click="regresar()" v-if="step == 1">Regresar</button>
                </div>
            </div>
            <div class="row">
                <div v-for="especie in especies" class="col-sm-4 mb-3" :key="especie.id">
                    <div class="card hover-container" @click="seleccionarEspecie(especie)">
                        <div class="card-body">
                            <h5 class="card-title">{{ especie.nombre }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div v-for="cuidado in cuidados" class="col-sm-3" :key="cuidado.id">
                    <div class="card hover-container" @click="seleccionarAdiestramiento(cuidado)">
                        <div class="card-body">
                            <h5 class="card-title">{{ cuidado.titulo }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                step: 0,
                especies: [],
                cuidados: [],
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
                    });
            },
            regresar() {
                this.step = 0;
                this.cuidados = [];
            },
        },
        mounted() {
            this.sincronizar({}, 'get', '/especies/mostrar')
                .then(response => {
                    this.especies = response.data;
                });
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