
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('Insumos', require('./components/Insumos.vue'));
Vue.component('cliente', require('./components/Cliente.vue'));
Vue.component('rol', require('./components/Rol.vue'));
Vue.component('user', require('./components/User.vue'));
Vue.component('vehiculo', require('./components/Vehiculo.vue'));
Vue.component('chofer', require('./components/Chofer.vue'));
Vue.component('servicio', require('./components/Servicio.vue'));
Vue.component('servicioalmacen', require('./components/ServicioAlmacen.vue'));
Vue.component('mantenimiento', require('./components/Mantenimiento.vue'));
Vue.component('mantenimientoalmacen', require('./components/MantenimientoAlmacen.vue'));
Vue.component('devolucion', require('./components/Devolucion.vue'));
Vue.component('devolucionalmacen', require('./components/DevolucionAlmacen.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
        menu:0
    }
});
