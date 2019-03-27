<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header />

            <div class="col-12">
                <div class="row justify-content-center">
                    <chart-component :report="report" v-for="(report, key) in reports" v-bind:key="key"></chart-component>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Histórico de Participantes</h4>

                        <paginator :active="showPaginate" :meta="paginate.meta" :links="paginate.links" @changePaginate="changePaginate">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xl-4">
                                    <div class="form-group mb-3">
                                        <label for="search">Pesquisar</label>
                                        <input type="text" id="search" class="form-control" placeholder="Cod. Ingresso, Cod. Entrada, Nome e Email" v-model.lazy="search">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12">
                                    <table class="table table-sm table-hover table-centered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Participante</th>
                                            <th>Email</th>
                                            <th>Cod. Ingresso</th>
                                            <th>Entrada</th>
                                            <th>Cod. Pedido</th>
                                            <th>Forma de Compra</th>
                                            <th>Data da Compra</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="value in paginate.data">
                                            <td>
                                                <i class="mdi mdi-circle ml-1" :class="colorStatus(value.status)"></i>
                                            </td>
                                            <td>{{value.name}}</td>
                                            <td>{{value.email}}</td>
                                            <td>{{value.code}}</td>
                                            <td>{{value.entrance}}</td>
                                            <td>{{value.order}}</td>
                                            <td>{{translateTypeBuy(value.channel)}}</td>
                                            <td>{{value.created_at}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </paginator>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import Paginator from '../../../../../components/datatable/paginator'
    import ChartComponent from '../../../../../components/chartComponent'

    import {toSeek} from "../../../../../vendor/common";
    import {mapState} from 'vuex'

    export default {
        name: "index",
        components: {
            Paginator,
            SubHeader,
            ChartComponent
        },
        data: () => ({
            paginate: {},
            search: '',
            reports: {
                sold: {
                    url: 'sold-tickets',
                    col: 'col-4',
                    icon: 'fas fa-users',
                    name: 'Participantes Confirmados',
                    color: '#6000a7',
                    chart: 'line',
                    type: 'int'
                },
                pending: {
                    url: 'pending-tickets',
                    col: 'col-4',
                    icon: 'fas fa-users',
                    name: 'Participantes Pendentes',
                    color: '#ffbc00',
                    chart: 'line',
                    type: 'int'
                },
                canceled: {
                    url: 'canceled-tickets',
                    col: 'col-4',
                    icon: 'fas fa-users',
                    name: 'Inscrições Canceladas',
                    color: '#fa5c7c',
                    chart: 'line',
                    type: 'int'
                }
            }
        }),
        watch: {
            search(value) {
                let params = null

                if(value !== '') params = {search: value}

                toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/reports/participants`, params).then(
                    response => {
                        this.changePaginate(response)
                    }
                )
            }
        },
        computed: {
            ...mapState({
                event: state => state.event
            }),
            showPaginate() {
                return this.search !== ''
            }
        },
        methods: {
            changePaginate(paginate) {
                this.paginate = paginate
            },
            colorStatus(status) {
                let obj = {
                    paid: 'text-success',
                    canceled: 'text-danger',
                    waiting: 'text-warning'
                }

                return obj[status]
            },
            translateTypeBuy(type) {
                let obj = {
                    admin: 'Inscrição de Administrador',
                    pdv: 'Inscrição PVD',
                    online: 'Inscrição Online'
                }

                return obj[type]
            }
        },
        mounted() {
            toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/reports/participants`).then(
                response => {
                    this.changePaginate(response)
                }
            )
        }
    }
</script>
