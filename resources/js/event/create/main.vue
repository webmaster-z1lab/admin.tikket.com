<template>
    <div>
        <loading-component :is-loading="isLoading"></loading-component>
        <component :is="layout" @loading="loading">
            <router-view @loading="loading"/>
        </component>
    </div>
</template>

<script>
    import LoadingComponent from '../../components/loadingComponent'
    import LocalStorage from "../../vendor/storage"

    import LayoutDefault from "./layouts/Default"
    import LayoutError from "./layouts/Error"

    import {mapActions} from 'vuex'
    import {toSeek} from "../../vendor/common";

    export default {
        name: 'VueMain',
        components: {
            LoadingComponent,
            LayoutDefault,
            LayoutError
        },
        data: () => ({
            isLoading: true
        }),
        computed: {
            layout() {
                return `layout-${(this.$route.meta.layout || 'default')}`
            },
            transition() {
                return this.$route.meta.transition | 'none'
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            ...mapActions(['changeEvent']),
            fetchData() {
                if (this.$route.meta.layout !== 'error') {
                    let event_id = new LocalStorage('event__').getItem('id')

                    if (event_id) {
                        toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${event_id}`).then(
                            async response => {
                                await this.changeEvent(response.data)
                            }
                        )
                    }
                }

                this.isLoading = false
            },
            loading(value) {
                this.isLoading = value
                value ? Pace.start() : Pace.stop()
            }
        }
    }
</script>
