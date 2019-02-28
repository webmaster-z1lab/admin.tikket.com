<template>
    <div class="col-12">
        <div class="row">
            <div class="col">
                <h4 class="header-title" style="font-size: 1.1rem">
                    Ingressos
                </h4>
            </div>
            <div class="col text-right">
                <button type="button" @click="ticket(true)" class="btn btn-icon btn-primary">
                    <i class="fas fa-plus"></i> Criar Ingresso
                </button>
            </div>
        </div>

        <div class="form-group col-12">
            <label class="col-form-label"> Absolver Taxa?</label>
            <div class="custom-control custom-checkbox form-custom" style="padding-left: 0">
                <input type="checkbox" id="switch1" data-switch="bool" name="private" v-model="event.attributes.fee_is_hidden" @click="changeFee">
                <label for="switch1" data-on-label="Sim" data-off-label="Não"></label>
            </div>
        </div>

        <div class="table-responsive-sm mt-3">
            <table class="table table-striped table-centered mb-0">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data Inicial</th>
                    <th>Taxa</th>
                    <th>Forma de Exibição</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="entrance in event.relationships.entrances">
                    <td>{{entrance.attributes.name}}</td>
                    <td>{{entrance.attributes.starts_at}}</td>
                    <td>{{(entrance.attributes.lots[0].fee / 100) | currency}}</td>
                    <td v-if="event.attributes.fee_is_hidden">{{(entrance.attributes.lots[0].price / 100) | currency}}</td>
                    <td v-else>{{(entrance.attributes.lots[0].value / 100) | currency}} (+ taxa de serviço de {{(entrance.attributes.lots[0].fee / 100) | currency }})</td>
                    <td class="table-action text-center">
                        <a href="javascript:;" class="action-icon" @click="ticket(false, entrance)"><i class="mdi mdi-pencil"></i></a>
                        <a href="javascript:;" class="action-icon" @click="deleteTicket(entrance)"> <i class="mdi mdi-delete"></i></a>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="text-center mt-2" v-if="checkEntrances">
                <figure class="mx-auto mb-4">
                    <img src="https://cdn.z1lab.com.br/images/undraw/undraw_analysis_4jis.svg" alt="SVG"
                         width="20%">
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

        <ul class="list-inline mb-2 mt-3 wizard" v-if="!checkEntrances">
            <li class="next list-inline-item float-right">
                <button type="button" class="btn btn-success" @click="submit">Concluir</button>
            </li>
        </ul>
    </div>
</template>

<script>
    import swal from 'sweetalert2'
    import LocalStorage from "../../../../vendor/storage"

    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST, sendAPIDELETE, exceptionError, sendAlert} from "../../../../vendor/common"

    export default {
        name: "ticket",
        computed: {
            ...mapState({
                event: state => state.event
            }),
            checkEntrances() {
                return _.isEmpty(this.event.relationships.entrances)
            }
        },
        methods: {
            ...mapActions(['setTicket', 'changeEvent']),
            changeFee(e) {
                this.$emit('loading', true)

                sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/fee`, {fee_is_hidden: e.target.checked, _method: 'PATCH'})
                    .then(response => {
                        this.changeEvent(response.data.data)

                        sendAlert({
                            title: 'Tudo Certo!',
                            message: 'Forma de trabalhar com a taxa modificada.',
                            type: 'success'
                        })
                    })
                    .catch((error) => exceptionError(error))
                    .finally(() => this.$emit('loading', false))
            },
            ticket(new_ticket, ticket) {
                if (new_ticket) {
                    this.setTicket({
                        id: null,
                        name: '',
                        free_ticket: false,
                        summary: '',
                        starts_at: '',
                        quant_min: 1,
                        quant_max: 5,
                        lots: [
                            {
                                amount:  '',
                                finishes_at: '',
                                value: 0
                            }
                        ]
                    })

                    this.$router.push({name: 'tickets.ticket'})
                } else {
                    let lots = []

                    for (let lot of ticket.attributes.lots) {
                        lots.push({
                            amount: lot.amount,
                            finishes_at: lot.finishes_at,
                            value: (lot.value / 100)
                        })
                    }

                    this.setTicket({
                        id: ticket.id,
                        name: ticket.attributes.name,
                        free_ticket: ticket.attributes.is_free,
                        summary: ticket.attributes.description,
                        starts_at: ticket.attributes.starts_at,
                        quant_min: ticket.attributes.min_buy,
                        quant_max: ticket.attributes.max_buy,
                        lots: lots
                    })

                    this.$router.push({name: 'tickets.ticket'})
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
                        this.$emit('loading', true)

                        sendAPIDELETE(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/entrances/${ticket.id}`, {})
                            .then(response => {
                                sendAlert({
                                    title: 'Tudo Certo!',
                                    message: 'Ingresso removido.',
                                    type: 'success'
                                })

                                this.changeEvent(response.data.data)
                            })
                            .catch((error) => exceptionError(error))
                            .finally(() => this.$emit('loading', false))
                    }
                })
            },
            submit() {
                if (_.isEmpty(this.event.relationships.producer)) {
                    sendAlert({
                        title: 'Ops, Algo está faltando!',
                        message: 'Antes de Continuar você deve preencher os campos do Organizador do evento e salva-lo.',
                        type: 'error',
                        time: 5000
                    })

                    return;
                } else if (_.isEmpty(this.event.attributes.address)) {
                    sendAlert({
                        title: 'Ops, Algo está faltando!',
                        message: 'Antes de Continuar você deve preencher os campos de endereço do evento e salva-lo.',
                        type: 'error',
                        time: 5000
                    })

                    return;
                }

                this.$emit('loading', true)

                sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/finalize`, {_method: 'PATCH'})
                    .then(response => {
                        new LocalStorage('event__').removeItem('id')

                        window.location.href = route('event.edit', response.data.data.id)
                    })
                    .catch((error) => {
                        this.$emit('loading', false)
                        exceptionError(error)
                    })
            }
        }
    }
</script>
