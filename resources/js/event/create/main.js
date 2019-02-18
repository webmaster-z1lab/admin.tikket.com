import Vue from 'vue'
import VueRouter from 'vue-router'
import VueCurrencyFilter from 'vue-currency-filter'

/* Configs */
import VueMain from './main.vue'
import store from './store/store'
import routes from './router'

/* Local Storage */
import LocalStorage from "../../vendor/storage"

/* Maps */
import * as VueGoogleMaps from "vue2-google-maps";

Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyAZVMJvQZclH-viCjrp6xm4bzUnyQv8FOo",
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
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresStartEvent)) {
        let event_id = new LocalStorage('event__').getItem('id')

        if (event_id){
            next()
        } else {
            next({name: 'information'})
        }
    } else {
        next()
    }
})

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
    el: '#vue-event-create',
    name: 'VueEventCreate',
    render: h => h(VueMain),
    store,
    router
});
