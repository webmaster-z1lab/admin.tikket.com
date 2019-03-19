<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header />

            <div class="col-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="mt-0 text-truncate" title="Quant. Participantes">
                                            <i class="fas fa-users text-primary mr-1"></i>
                                            Quant. Participantes
                                        </h5>
                                        <h3 class="my-2 py-1">0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="mt-0 text-truncate" title="Quant. Confimados">
                                            <i class="fas fa-users text-success mr-1"></i>
                                            Quant. Confimados
                                        </h5>
                                        <h3 class="my-2 py-1">0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="mt-0 text-truncate" title="Quant. Cancelados">
                                            <i class="fas fa-users text-danger mr-1"></i>
                                            Quant. Cancelados
                                        </h5>
                                        <h3 class="my-2 py-1">0</h3>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right" style="position: relative;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
