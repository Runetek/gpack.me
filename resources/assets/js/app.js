import Vue from 'vue'
import { VueTyper } from 'vue-typer'

require('./bootstrap')

window.Vue = require('vue')

Vue.component('vue-typer', VueTyper)
Vue.component('example-component', require('./components/ExampleComponent.vue'))

const app = new Vue({
    el: '#app'
})
