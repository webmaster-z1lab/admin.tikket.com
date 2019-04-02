<template>
    <div class="card-body">
        <loading-component :is-loading="isLoading"></loading-component>

        <div class="d-flex justify-content-end mb-4">
            <button type="button" class="btn btn-sm btn-danger" title="cancelar pedido" v-if="cancelOrder" @click="canceledOrder">
                <i class="fas fa-trash"></i> Cancelar Pedido
            </button>
        </div>

        <div class="card cta-box text-white" :class="themeStatus.color">
            <div class="card-body">
                <div class="media align-items-center">
                    <div class="media-body">
                        <h4 class="mt-0">Pedido Nº {{id}}</h4>
                        <h5 class="m-0 font-weight-normal mb-1"><b>Status:</b> {{themeStatus.translate}}</h5>
                        <h5 class="m-0 font-weight-normal mb-1"><b>Data da Compra:</b> {{order.created_at}}</h5>
                        <h5 class="m-0 font-weight-normal mb-1"><b>Valor do Pedido:</b> {{((order.amount + order.fee)/ 100) | currency}}</h5>
                        <h5 class="m-0 font-weight-normal mb-1"><b>Forma da Compra:</b> {{translateTypeBuy(order.channel)}}</h5>
                    </div>
                    <img class="ml-3" :src="themeStatus.svg" width="120" alt="Generic placeholder image">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="card-widgets">
                    <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1">
                        <i class="mdi mdi-minus"></i>
                    </a>
                </div>
                    <h5 class="card-title mb-0">Resumo do Pedido</h5>

                <div id="cardCollpase1" class="collapse show pt-3">
                    <div class="table-responsive-sm">
                        <table class="table table-sm table-centered mb-0">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Participante</th>
                                <th>Email</th>
                                <th>Entrada</th>
                                <th>Valor</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="ticket in order.tickets">
                                <td>{{ticket.code || '-'}}</td>
                                <td>{{ticket.name || '-'}}</td>
                                <td>{{ticket.email || '-'}}</td>
                                <td>{{ticket.entrance}}</td>
                                <td>{{(ticket.price / 100) | currency}}</td>
                            </tr>
                            <tr>
                                <td colspan="4"><b>Valor Total</b></td>
                                <td><b>{{((order.amount + order.fee)/ 100) | currency}}</b></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-secondary" @click="$emit('close')">Sair</button>
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert2'
    import LoadingComponent from '../../../../../../components/loadingComponent'

    import {toSeek, sendAPIDELETE, sendAlert, exceptionError} from "../../../../../../vendor/common"
    import {mapState} from 'vuex'

    export default {
        name: "order",
        props: {
            id: {
                type: String,
                required: true
            }
        },
        components: {
            LoadingComponent
        },
        watch: {
            id(value) {
                toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/orders/${value}`).then(
                    response => {
                        this.order = response.data.attributes
                    }
                )
            }
        },
        data: () => ({
            order: {},
            isLoading: false
        }),
        computed: {
            ...mapState({
                event: state => state.event
            }),
            themeStatus() {
                let options = {
                    waiting: {
                        color: 'bg-warning',
                        svg: 'http://127.0.0.5:8000/svg/undraw_loading_frh4.svg',
                        translate: 'Aguardando Pagamento'
                    },
                    paid: {
                        color: 'bg-success',
                        svg: 'http://127.0.0.5:8000/svg/undraw_order_confirmed_1m3v.svg',
                        translate: 'Pagamento Confirmado'
                    },
                    canceled: {
                        color: 'bg-danger',
                        svg: 'http://127.0.0.5:8000/svg/undraw_cancel_u1it.svg',
                        translate: 'Cancelado'
                    }
                }

                return options[this.order.status] || {color: 'bg-primary', svg: 'http://127.0.0.5:8000/svg/undraw_voice_control_ofo1.svg', translate: '' }
            },
            cancelOrder() {
                return this.order.status === 'waiting' || this.order.status === 'paid'
            }
        },
        methods: {
            translateTypeBuy(type) {
                let obj = {
                    admin: 'Inscrição de Administrador',
                    pdv: 'Inscrição PVD',
                    online: 'Inscrição Online'
                }

                return obj[type]
            },
            canceledOrder(){
                swal({
                    title: 'Você tem certeza?',
                    text: "Ao fazer isso o pedido será cancelado junto com todos ingressos presentes nele!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, apagar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true

                        sendAPIDELETE(`${process.env.MIX_API_VERSION_ENDPOINT}/orders/${this.id}`, {})
                            .then(response => {
                                sendAlert({
                                    title: 'Tudo Certo!',
                                    message: 'Pedido Cancelado.',
                                    type: 'success'
                                })

                                this.isLoading = false
                                window.location.reload()
                            })
                            .catch((error) => {
                                this.isLoading = false
                                exceptionError(error)
                            })
                    }
                })
            }
        }
    }
</script>
