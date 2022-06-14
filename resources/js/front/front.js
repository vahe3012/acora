import Vue from 'vue'
import Vuex from 'vuex'

// import store from './store.js'
// import services from "./services"
// import constants from "./services/constants"

window._ = require('lodash')

try {
    window.Popper = require('popper.js').default
    window.$ = window.jQuery = require('jquery')

    require('bootstrap')
} catch (e) {}

window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

Vue.use(Vuex)

const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.mixin({
    methods: services,
    data: function () {
        return {
            constants: constants,
            _configs: _configs,
        }
    }
})

window.Vue = Vue
window.Vuex = Vuex

const vueApp = new Vue({
    el: '#front',
    store: new Vuex.Store(store)
});
window.vueApp = vueApp

console.log('CURRENT STATE: ', vueApp.$store.state)
