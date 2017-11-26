import Vue from 'vue'
import { VueTyper } from 'vue-typer'
import VueTable from 'vuetable-2'

// require('./bootstrap')

Vue.use(VueTable)

Vue.component('vuetable', VueTable)

Vue.component('vue-typer', VueTyper)
Vue.component('artifact-table', require('./components/ArtifactTable.vue'))
Vue.component('download-button', require('./components/DownloadButton.vue'))

const app = new Vue({
    el: '#app'
})
