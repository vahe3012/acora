import Vue from "vue"
import _ from 'lodash'

try {
    window.Popper = require('popper.js').default
    window.$ = window.jQuery = require('jquery')

    // require('bootstrap')

} catch (e) {}

window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

window.Vue = Vue

const files = require.context('./components', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.prototype._configs = window._configs
Vue.prototype.$_ = _


const app = new Vue({
    el: '#admin',


});
