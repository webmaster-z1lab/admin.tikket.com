<template>
    <div class="card-body">
        <div class="card-widgets">
            <button type="button" @click="ticket(true)" class="btn btn-icon btn-primary btn-sm">
                <i class="fas fa-plus"></i> Criar Ingresso
            </button>
        </div>
        <h4 class="card-title mb-0">Ingressos</h4>

        <div class="table-responsive-sm mt-3">
            <table class="table table-striped table-centered mb-0">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data Inicial</th>
                    <th>Taxa</th>
                    <th>Valor do Ingresso</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="entrance in event.relationships.entrances">
                    <td>{{entrance.attributes.name}}</td>
                    <td>{{entrance.attributes.starts_at}}</td>
                    <td>{{(entrance.attributes.lots[0].fee / 100) | currency}}</td>
                    <td v-if="event.attributes.fee_is_hidden">{{(entrance.attributes.lots[0].price / 100) | currency}}</td>
                    <td v-else>
                        {{(entrance.attributes.lots[0].value / 100) | currency}} (+ taxa de serviço de {{(entrance.attributes.lots[0].fee / 100) | currency }})
                    </td>
                    <td class="table-action text-center">
                        <a href="javascript:;" class="action-icon" @click="ticket(false, entrance)">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                        <a href="javascript:;" class="action-icon" @click="deleteTicket(entrance)" v-if="!entrance.attributes.is_locked">
                            <i class="mdi mdi-delete"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="text-center mt-2" v-if="checkEntrances">
                <figure class="mx-auto mb-4">
                    <img :src="'images/undraw/undraw_analysis_4jis.svg'| aws_url" alt="SVG" width="20%">
                </figure>

                <div class="mb-4">
                    <h1 class="h3"><strong>Nenhum ingresso cadastrado</strong></h1>

                    <p class="h5">Para continuar você precisa ter pelo menos um ingresso cadastrado!</p>

                    <button type="button" @click="ticket(true)" class="btn btn-icon btn-primary">
                        Adicionar Ingresso
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert2'

    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST, sendAPIDELETE, exceptionError, sendAlert} from "../../../../../../vendor/common"

    export default {
        name: "tickets",
        computed: {
            ...mapState({
                event: state => state.event
            }),
            checkEntrances() {
                return _.isEmpty(this.event.relationships.entrances)
            }
        },
        methods: {
            ...mapActions(['setTicket', 'changeEvent', 'changeLoading']),
            changeFee(e) {
                this.changeLoading(true)

                sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/fee`, {fee_is_hidden: e.target.checked, _method: 'PATCH'})
                    .then(response => {
                        this.changeEvent(response.data.data)

                        sendAlert({
                            title: 'Tudo Certo!',
                            message: 'Forma de trabalhar com a taxa modificada.',
                            type: 'success'
                        })
                    })
                    .catch((error) => {
                        this.changeLoading(false)
                        exceptionError(error)
                    })
            },
            ticket(new_ticket, ticket) {
                if (new_ticket) {
                    this.setTicket({
                        id: null,
                        name: '',
                        free_ticket: false,
                        is_locked: false,
                        summary: '',
                        starts_at: '',
                        quant_min: 1,
                        quant_max: 5,
                        lots: [
                            {
                                amount:  '',
                                finishes_at: '',
                                value: 0,
                                status: 'open'
                            }
                        ]
                    })

                    this.$emit('changePage', 'new-edit-ticket')
                } else {
                    let lots = []

                    for (let lot of ticket.attributes.lots) {
                        lots.push({
                            amount: lot.amount,
                            finishes_at: lot.finishes_at,
                            value: (lot.value / 100),
                            status: lot.status
                        })
                    }

                    this.setTicket({
                        id: ticket.id,
                        name: ticket.attributes.name,
                        free_ticket: ticket.attributes.is_free,
                        is_locked: ticket.attributes.is_locked,
                        summary: ticket.attributes.description,
                        starts_at: ticket.attributes.starts_at,
                        quant_min: ticket.attributes.min_buy,
                        quant_max: ticket.attributes.max_buy,
                        lots: lots
                    })

                    this.$emit('changePage', 'new-edit-ticket')
                }
            },
            deleteTicket(ticket){
                swal({
                    title: 'Você tem certeza?',
                    text: "Ao fazer isso o Ingresso será apagado!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, apagar!'
                }).then((result) => {
                    if (result.value) {
                        this.changeLoading(true)

                        sendAPIDELETE(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/entrances/${ticket.id}`, {})
                            .then(response => {
                                sendAlert({
                                    title: 'Tudo Certo!',
                                    message: 'Ingresso removido.',
                                    type: 'success'
                                })

                                this.changeEvent(response.data.data)
                            })
                            .catch((error) => {
                                this.changeLoading(false)
                                exceptionError(error)
                            })
                    }
                })
            }
        }
    }
</script>
