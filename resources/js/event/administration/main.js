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
        key: process.env.MIX_GOOGLE_API_KEY,
        libraries: "places"
    }
});

/* Validate */
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate, { inject: false })

require('../../forms/config/validator')

/* Route */
Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
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
    el: '#vue-event-administration',
    name: 'VueEventAdministration',
    render(h) {
        return h(VueMain, {props: {data: this.$el.attributes.data.value}})
    },
    store,
    router
});
