<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header />

            <div class="col-12">
                <div class="row justify-content-center">
                    <chart-component :report="report" v-for="(report, key) in reports" v-bind:key="key"></chart-component>
                </div>
            </div>

            <div class="col-4">
                <h1>assa</h1>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Histórico de Pedidos</h4>

                        <paginator :active="showPaginate" :meta="paginate.meta" :links="paginate.links" @changePaginate="changePaginate">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xl-4">
                                    <div class="form-group mb-3">
                                        <label for="search">Pesquisar</label>
                                        <input type="text" id="search" class="form-control" placeholder="Cod. Pedido, Nome e Email" v-model.lazy="search">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12">
                                    <table class="table table-hover table-centered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Comprador</th>
                                            <th>Cod. Pedido</th>
                                            <th>Forma de Compra</th>
                                            <th>Data da Compra</th>
                                            <th>Valor</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="value in paginate.data">
                                            <td>
                                                <i class="mdi mdi-circle ml-1" :class="colorStatus(value.status)"></i>
                                            </td>
                                            <td>{{value.name}}</td>
                                            <td>{{value.order}}</td>
                                            <td>{{translateTypeBuy(value.channel)}}</td>
                                            <td>{{value.created_at}}</td>
                                            <td>{{(value.price / 100) | currency}}</td>
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
            SubHeader,
            Paginator,
            ChartComponent
        },
        data: () => ({
            paginate: {},
            search: '',
            reports: {
                sales: {
                    url: 'sales',
                    col: 'col-md-6 col-xl-3',
                    name: 'Total das Vendas',
                    chart: 'line',
                    color: '#0acf97',
                    type: 'money'
                },
                netValue: {
                    url: 'net-value',
                    col: 'col-md-6 col-xl-3',
                    name: 'Total para Repasse',
                    chart: 'line',
                    color: '#39afd1',
                    type: 'money'
                },
                pending: {
                    url: 'pending-values',
                    col: 'col-md-6 col-xl-3',
                    name: 'Vendas Pendentes',
                    chart: 'line',
                    color: '#ffbc00',
                    type: 'money'
                },
                canceled: {
                    url: 'canceled-values',
                    col: 'col-md-6 col-xl-3',
                    name: 'Total de Cancelados',
                    chart: 'line',
                    color: '#fa5c7c',
                    type: 'money'
                },
            }
        }),
        watch: {
            search(value) {
                let params = null

                if(value !== '') params = {search: value}

                toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/reports/orders`, params).then(
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
                    admin: 'Incrição de Administrador',
                    pdv: 'Incrição PVD',
                    online: 'Incrição Online'
                }

                return obj[type]
            }
        },
        mounted() {
            toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/reports/orders`).then(
                response => {
                    this.changePaginate(response)
                }
            )
        }
    }
</script>
