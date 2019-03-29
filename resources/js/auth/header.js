import Vue from 'vue'
import {toSeek, sendCommon} from "../vendor/common"

import LoadingComponent from '../components/loadingComponent'

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
