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

                        <paginator :active="showPaginate" :meta="participants.meta" :links="participants.links" @changePaginate="changeParticipants">
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
                                        <tr v-if="checkParticipants">
                                            <td colspan="8">
                                                <div class="text-center mt-2">
                                                    <figure class="mx-auto mb-4">
                                                        <img src="http://127.0.0.5:8000/svg/undraw_mobile_marketing_iqbr.svg" alt="SVG" width="20%">
                                                    </figure>

                                                    <div class="mb-4">
                                                        <h1 class="h3"><strong>Nenhum Participante encontrado</strong></h1>

                                                        <p class="h5">Divulgue seu evento para mais pessoas poderem participar.</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-for="participant in participants.data" v-else>
                                            <td>
                                                <i class="mdi mdi-circle ml-1" :class="colorStatus(participant.status)"></i>
                                            </td>
                                            <td>{{participant.name}}</td>
                                            <td>{{participant.email}}</td>
                                            <td>{{participant.code}}</td>
                                            <td>{{participant.entrance}}</td>
                                            <td>{{participant.order}}</td>
                                            <td>{{translateTypeBuy(participant.channel)}}</td>
                                            <td>{{participant.created_at}}</td>
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
            participants: {},
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
            },
            checkParticipants() {
                return _.isEmpty(this.participants.data)
            }
        },
        methods: {
            changeParticipants(participants) {
                this.participants = participants
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
                    this.changeParticipants(response)
                }
            )
        }
    }
</script>
