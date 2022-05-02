/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('registro-mascota', require('./components/RegistrarMascota.vue').default);
Vue.component('mostrar-mascota', require('./components/MostrarMascota.vue').default);
Vue.component('actualizar-mascota', require('./components/ActualizarMascota.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        mascota: '',
        formularios: {
            registroMascota: {mostrar: false},
            mostrarMascota: {mostrar: false},
            actualizarMascota: {mostrar: false}
        }
    },
    methods: {
        mostrarFormulario(formulario) {
            for (let key in this.formularios) {
                if (key === formulario) {
                    this.formularios[key].mostrar = true;
                } else {
                    this.formularios[key].mostrar = false;
                }
            }
        }
    },
    beforeMount() {
        this.$root.$on('close', (value) => {
            this.formularios[value].mostrar = false;
            if (value == 'registroMascota' || value == 'actualizarMascota') {
                this.formularios.mostrarMascota.mostrar = true;
            }
        });
        this.$root.$on('editar-mascota', (value) => {
            this.formularios.mostrarMascota.mostrar = false;
            this.formularios.actualizarMascota.mostrar = true;
            this.mascota = value;
        });
    }
});
