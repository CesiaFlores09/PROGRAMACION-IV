<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Nuevo cuido</h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="nuevoCuido" @reset.prevent="borrar">
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
                            <textarea class="form-control" placeholder="Descripcion" ref="descripcion" id="editor2"></textarea>
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
            nuevoCuido() {
                let datos = {
                    idEspecie: this.nuevo.especie.id,
                    titulo: this.nuevo.titulo,
                    consejo: this.editor.getData(),
                }
                console.log(datos)
                let cuidados = localStorage.getItem('cuidados')
                if (cuidados) {
                    cuidados = JSON.parse(cuidados)
                    cuidados.push(datos)
                    localStorage.setItem('cuidados', JSON.stringify(cuidados))
                } else {
                    cuidados = []
                    cuidados.push(datos)
                    localStorage.setItem('cuidados', JSON.stringify(cuidados))
                }
                this.sincronizar(datos, 'post', '/cuidos/nuevo')
                    .then(response => {
                        console.log(response.data);
                        this.$root.$emit('open', 'cuidos');
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
            if (localStorage.getItem('especies') == null) {
                this.sincronizar({}, 'get', '/especies/mostrar')
                    .then(response => {
                        localStorage.setItem('especies', JSON.stringify(response.data));
                        this.especies = response.data;
                    });
            } else {
                this.especies = JSON.parse(localStorage.getItem('especies'));
                console.log(this.especies);
            }

            this.$nextTick(() => {
                this.editor = CKEDITOR.replace( 'editor2' );
            });
        }
    }
</script>