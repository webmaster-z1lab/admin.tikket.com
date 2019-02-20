<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header />

            <div class="col-12">
                <div class="col-8">
                    <h1>Painel Principal de administração do evento</h1>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import {mapActions, mapState} from 'vuex'

    export default {
        name: "index",
        components: {
            SubHeader
        },
        data: () => ({

        }),
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        methods: {
            ...mapActions(['changeEvent'])
        }
    }
</script>
