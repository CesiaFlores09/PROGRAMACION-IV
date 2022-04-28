<template>
    <div class="card">
        <div class="card-header center-content">
            <p>Buscar mascotas</p>
        </div>
        <div class="card-body">
            <div v-for="mascota in mascotas" class="row mb-3" :key="mascota.id">
                <div class="col-md-4">
                    <img :src="'storage/imagenes/mascotas/fotos/'+mascota.imagen" alt="" class="img-fluid" style="max-width: 200px;">
                </div>
                <div class="col-md-4">
                    <h3>{{ mascota.nombre }}</h3>
                    <p>Color: {{ mascota.color }}</p>
                    <p>Raza: {{ mascota.raza }}</p>
                    <p>Edad: {{ mascota.edad }}</p>
                </div>
                <div class="col-md-4">
                    <img :src="'storage/imagenes/mascotas/cartillas/'+mascota.cartilla" alt="" class="img-fluid" style="max-width: 200px;">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import vueSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css'
    export default {
        data() {
            return {
                mascotas: [],
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
                        this.mascotas = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
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
</style>