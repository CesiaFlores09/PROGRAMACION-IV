<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Nuevo adiestramiento</h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="nuevoAdiestramiento" @reset.prevent="borrar">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">Especie</label>
                        <div class="col-md-8">
                            <v-select :options="especies" v-model="nuevo.especie" label="nombre" placeholder="Seleccione una especie"></v-select>
                        </div>
                        <div v-if="errors.especie" class="alert alert-danger col-md-8 fs-6 mx-auto">  
                            <span v-for="error in errors.especie" :key="error" class="font-weight-bold pf-1">{{ error }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">Titulo</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" v-model="nuevo.titulo" placeholder="Titulo">
                        </div>
                        <div v-if="errors.titulo" class="alert alert-danger col-md-8 fs-6 mx-auto">  
                            <span v-for="error in errors.titulo" :key="error" class="font-weight-bold pf-1">{{ error }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">Descripcion</label>
                        <div class="col-md-12">
                            <textarea class="form-control" placeholder="Descripcion" ref="descripcion" id="editor1"></textarea>
                        </div>
                        <div v-if="errors.descripcion" class="alert alert-danger col-md-8 fs-6 mx-auto">  
                            <span v-for="error in errors.descripcion" :key="error" class="font-weight-bold pf-1">{{ error }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                            <button class="btn btn-secondary" type="reset">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import vueSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css'
    import '../ckeditor/ckeditor.js'
    export default {
        data() {
            return {
                especies: [],
                nuevo: {
                    especie: null,
                    titulo: null,
                },
                errors: {},
                editor: null,
            }
        },
        components: {
            'v-select': vueSelect,
        },
        methods: {
            sincronizar(datos, metodo, url) {
                return axios[metodo](url, datos)
            },
            nuevoAdiestramiento() {
                let datos = {
                    idEspecie: this.nuevo.especie.id,
                    titulo: this.nuevo.titulo,
                    descripcion: this.editor.getData(),
                }
                console.log(datos)
                this.sincronizar(datos, 'post', '/adiestramiento/nuevo')
                    .then(response => {
                        console.log(response.data)
                        this.$emit('open', 'adiestramiento')
                    });
            },
            borrar() {
                this.nuevo = {
                    especie: null,
                    titulo: null,
                }
                this.editor.setData('')
            },
        },
        mounted() {
            this.sincronizar({}, 'get', '/especies/mostrar')
                .then(response => {
                    this.especies = response.data;
                });

            this.$nextTick(() => {
                this.editor = CKEDITOR.replace( 'editor1' );
            });
        }
    }
</script>