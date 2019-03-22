<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <sub-header />

            <div :class="page === 'accesses' ? 'col-12' : 'col-8 justify-content-center'">
                <div class="card">
                    <component :is="page" @changePage="changePage"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import Accesses from './partials/accesses'
    import NewAccess from './partials/new-access'

    import {mapState} from 'vuex'

    export default {
        name: "accessLevel",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            SubHeader,
            Accesses,
            NewAccess
        },
        data: () => ({
            page: 'accesses'
        }),
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        methods:{
            changePage(page) {
                this.page = page
            }
        }
    }
</script>
