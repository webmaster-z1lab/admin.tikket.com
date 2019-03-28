import Vue from 'vue'

/* Configs */
import VueMain from './main.vue'
import store from './store/store'

/* Validate */
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate, { inject: false })

require('../../forms/config/validator')

/* Money */
import VueCurrencyFilter from 'vue-currency-filter'

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
    el: '#vue-order-manual',
    name: 'VueOrderManual',
    render(h) {
        return h(VueMain, {props: {data: this.$el.attributes.data.value}})
    },
    store
});
