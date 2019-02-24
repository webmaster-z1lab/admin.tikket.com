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
                                        <h5 class="mt-0 text-truncate" title="Ingressos Vendidos">
                                            <i class="fas fa-ticket-alt text-success mr-1"></i>
                                            Ingressos Vendidos
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
                                        <h5 class="mt-0 text-truncate" title="Ingressos Pendentes">
                                            <i class="fas fa-ticket-alt text-warning mr-1"></i>
                                            Ingressos Pendentes
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
                                        <h5 class="mt-0 text-truncate" title="Ingressos Cancelados">
                                            <i class="fas fa-ticket-alt text-danger mr-1"></i>
                                            Ingressos Cancelados
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
                <div class="card">
                    <component :is="page" @changePage="changePage"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import Tickets from './partials/tickets'
    import NewEditTicket from './partials/new-edit-ticket'

    import {mapState} from 'vuex'

    export default {
        name: "index",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            SubHeader,
            Tickets,
            NewEditTicket
        },
        data: () => ({
            page: 'tickets'
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
