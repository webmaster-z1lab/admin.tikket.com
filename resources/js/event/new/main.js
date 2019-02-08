import Vue from 'vue'
import VueRouter from 'vue-router'
import VueCurrencyFilter from 'vue-currency-filter'

/* Configs */
import VueMain from './main.vue'
import store from './store/store'
import routes from './router'

/* Maps */
import * as VueGoogleMaps from "vue2-google-maps";

Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyAZVMJvQZclH-viCjrp6xm4bzUnyQv8FOo",
        libraries: "places" // necessary for places input
    }
});

/* Validate */
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate, { inject: false })

require('../../forms/config/validator')

/* Route */
Vue.use(VueRouter)
const router = new VueRouter({
    routes
});

/* Money */
Vue.use(VueCurrencyFilter,
    {
        symbol : 'R$',
        thousandsSeparator: '.',
        fractionCount: 2,
        fractionSeparator: ',',
        symbolPosition: 'front',
        symbolSpacing: true
    })

new Vue({
    el: '#vue-event-new',
    name: 'VueEventNew',
    render: h => h(VueMain),
    store,
    router
});
