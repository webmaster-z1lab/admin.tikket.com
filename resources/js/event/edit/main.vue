<template>
    <div>
        <loading-component :is-loading="isLoading"></loading-component>
        <component :is="layout">
            <router-view @loading="loading"/>
        </component>
    </div>
</template>

<script>
    import "../../bootstrap";

    import LoadingComponent from '../../components/loadingComponent'
    import LayoutDefault from "./components/layouts/default"
    import LayoutError from "./components/layouts/error"

    import {mapActions, mapState} from 'vuex'

    export default {
        name: 'VueMain',
        components: {
            LoadingComponent,
            LayoutDefault,
            LayoutError
        },
        data: () => ({
            isLoading: false
        }),
        props: {
            data: {
                required: true,
                type: String
            }
        },
        created() {
            if (_.isString(this.data)) this.initEvent(this.data)
        },
        computed: {
            ...mapState({
                event: state => state.event
            }),
            layout() {
                return `layout-${(this.$route.meta.layout || 'default')}`
            }
        },
        methods: {
            ...mapActions(['initEvent']),
            loading(value) {
                this.isLoading = value
                value ? Pace.start() : Pace.stop()
            }
        }
    }
</script>
