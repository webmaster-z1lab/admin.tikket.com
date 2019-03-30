import Vue from 'vue'
import {toSeek, sendCommon} from "../vendor/common"

import LoadingComponent from '../components/loadingComponent'
import LocalStorage from "../vendor/storage";

new Vue({
    name: 'header',
    el: '#vue-header',
    components: {
        LoadingComponent
    },
    data: () => ({
        logout: false,
        user: {},
        isLoading: false,
        urlSite: process.env.MIX_MAIN_SITE
    }),
    computed: {
        scheduleGreetings() {
            let data = new Date();
            let hora = data.getHours();

            if(hora >= 0 && hora <= 12){
                return "Bom Dia"
            }
            if(hora > 12 && hora <= 18){
                return "Boa Tarde"
            }
            if(hora > 18 && hora <= 24){
                return "Boa Noite"
            }
        }
    },
    methods: {
        async logoutSubmit() {
            this.isLoading = true

            this.logout = true

            await sendCommon(route('logout'), {}, 'POST').then(
                response => setTimeout(() => window.location.reload(), 1000)
            ).catch(
                error => {
                    this.isLoading = false
                    console.dir(error)
                }
            )
        },
        createEvent() {
            new LocalStorage('event__').removeItem('id')

            window.location.href = route('event.create')
        }
    },
    created() {
        toSeek(route('openid.user')).then(
            data => {
                this.user = data.data.attributes
            }
        );
    }
});
