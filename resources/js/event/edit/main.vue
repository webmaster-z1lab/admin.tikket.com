<template>
    <div>
        <loading-component :is-loading="isLoading"></loading-component>
        <component :is="layout">
            <router-view v-if="!isLoading"/>
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
        props: {
            data: {
                required: true,
                type: String
            }
        },
        computed: {
            ...mapState({
                isLoading: state => state.isLoading
            }),
            layout() {
                return `layout-${(this.$route.meta.layout || 'default')}`
            }
        },
        created() {
            if (_.isString(this.data)) this.initEvent(this.data)
        },
        methods: {
            ...mapActions(['initEvent'])
        }
    }
</script>
