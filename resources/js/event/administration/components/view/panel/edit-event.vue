<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <sub-header />

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-widgets">
                            <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1">
                                <i class="mdi mdi-minus"></i>
                            </a>
                        </div>
                        <h5 class="card-title mb-0">Editar Informações Base</h5>

                        <div id="cardCollpase1" class="collapse pt-3 show">
                            <info-base />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-widgets">
                            <a data-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2">
                                <i class="mdi mdi-minus"></i>
                            </a>
                        </div>
                        <h5 class="card-title mb-0">Editar Local do Evento</h5>

                        <div id="cardCollpase2" class="collapse pt-3 show">
                            <location />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import InfoBase from './partials/information'
    import Location from './partials/location'

    import {mapActions, mapState} from 'vuex'

    export default {
        name: "editEvent",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            SubHeader,
            InfoBase,
            Location
        },
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
