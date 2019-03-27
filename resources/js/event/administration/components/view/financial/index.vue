<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header />

            <div class="col-12">
                <div class="row justify-content-center">
                    <chart-component :report="report" v-for="(report, key) in reports" v-bind:key="key"></chart-component>
                </div>
            </div>

            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Relatórios dos PDVs</h4>
                        <div class="row" v-if="checkPDVs">
                            <div class="col-12" v-for="(pdv, key) in pdvs">
                                <h5 class="header-title mb-2">{{`${pdv.attributes.name} ${key + 1}`}}</h5>
                                <p class="text-muted font-14 mb-4">
                                    {{pdv.attributes.email}}
                                </p>
                                <div class="row">
                                    <chart-component :report="formatChart(pdv, 'tickets')" v-bind:key="`tickets-${key}`"></chart-component>
                                    <chart-component :report="formatChart(pdv, 'values')" v-bind:key="`values-${key}`"></chart-component>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-2" v-else>
                            <figure class="mx-auto mb-4">
                                <img src="http://127.0.0.5:8000/svg/undraw_voice_control_ofo1.svg" alt="SVG" width="20%">
                            </figure>

                            <div class="mb-4">
                                <h1 class="h3"><strong>Nenhum PDV foi cadastrado</strong></h1>

                                <p class="h5">Caso tenha o desejo de criar PDVs clique no botão abaixo!</p>

                                <router-link :to="{name: 'panel.access-level'}" class="btn btn-icon btn-primary">
                                    Criar PDV
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Resumo Financeiro</h4>
                        <div class="table-responsive-sm">
                            <table class="table table-centered mb-0">
                                <thead>
                                <tr>
                                    <th>Formas de Venda</th>
                                    <th>Quant.</th>
                                    <th>Valor</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Online</td>
                                    <td>{{summary.online.sales}}</td>
                                    <td>{{(summary.online.value / 100) | currency}}</td>
                                </tr>
                                <tr>
                                    <td>Manual</td>
                                    <td>{{summary.manual.sales}}</td>
                                    <td>{{(summary.manual.value / 100) | currency}}</td>
                                </tr>
                                <tr>
                                    <td rowspan="2"><strong>Totais</strong></td>
                                    <td><strong>Valor Total</strong></td>
                                    <td><strong>{{(summary.total.value / 100) | currency}}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Repasse Total</strong></td>
                                    <td><strong>{{(summary.net_value.total / 100) | currency}}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Histórico de Pedidos</h4>

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
                                    <table class="table table-sm table-hover table-centered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Comprador</th>
                                            <th>Cod. Pedido</th>
                                            <th>Forma de Compra</th>
                                            <th>Data da Compra</th>
                                            <th>Valor</th>
                                            <th>Ação</th>
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
                                            <td class="table-action text-center">
                                                <a href="javascript:;" class="action-icon" @click="openTheModal(value.order, `Pedido - ${value.order}`, 'small')">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
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

        <modal-component :title="title" ref="modalDefault" tabIndex="-1" id="modal-practice-lessons" :size='size'>
            <div slot="modal-body">
                <div class="modal-body">
                    <order :id="order_id" @close="closeTheModal" @update="updateOrders"></order>
                </div>
            </div>
        </modal-component>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import Paginator from '../../../../../components/datatable/paginator'
    import ChartComponent from '../../../../../components/chartComponent'
    import ModalComponent from '../../../../../components/modalComponent'
    import Order from './partials/order'

    import {toSeek} from "../../../../../vendor/common";
    import {mapState} from 'vuex'

    export default {
        name: "index",
        components: {
            SubHeader,
            Paginator,
            ChartComponent,
            ModalComponent,
            Order
        },
        data: () => ({
            size: 'large',
            title: '',
            order_id: '',
            paginate: {},
            pdvs: {},
            summary: {
                manual: {
                    sales: 0,
                    value: 0
                },
                net_value: {
                    online: 0,
                    total: 0
                },
                online: {
                    sales: 0,
                    value: 0
                },
                total: {
                    sales: 0,
                    value: 0
                }
            },
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
            },
            checkPDVs() {
                return !_.isEmpty(this.pdvs)
            }
        },
        methods: {
            formatChart(pdv, type) {
                return {
                    url: `sale-points/${pdv.id}/${type}`,
                    col: 'col-6',
                    name: type === 'values' ? 'Vendas Totais' : 'Ingressos Vendidos',
                    chart: 'line',
                    color: type === 'values' ? '#0acf97' : '#39afd1',
                    type: type === 'values' ? 'money' : 'int'
                }
            },
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
            },
            openTheModal(id, title, size) {
                this.title = title
                this.size = size
                this.order_id = id

                this.$refs.modalDefault.open()
            },
            closeTheModal() {
                this.$refs.modalDefault.close()
            },
            updateOrders() {
                toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/reports/orders`).then(
                    response => {
                        this.changePaginate(response)
                    }
                )
            }
        },
        mounted() {
            this.updateOrders()
            toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/sale-points`).then(
                response => {
                    this.pdvs = response.data
                }
            )
            toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/reports/summary`).then(
                response => {
                    this.summary = response.data
                }
            )
        }
    }
</script>
