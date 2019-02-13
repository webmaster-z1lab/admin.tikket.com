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
                <input type="checkbox" id="switch1" data-switch="bool" name="private" v-model="fee">
                <label for="switch1" data-on-label="Sim" data-off-label="Não"></label>
            </div>
        </div>

        <div class="table-responsive-sm mt-3">
            <table class="table table-striped table-centered mb-0">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Taxa</th>
                    <th>Preço Final</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="entrance in event.relationships.entrances">
                    <td>{{entrance.attributes.name}}</td>
                    <td>{{(entrance.attributes.lots[0].value / 100) | currency}}</td>
                    <td>{{(entrance.attributes.lots[0].fee / 100) | currency}}</td>
                    <td>{{(entrance.attributes.lots[0].price / 100) | currency}}</td>
                    <td class="table-action text-center">
                        <a href="javascript:;" class="action-icon" @click="ticket(false, entrance)"><i class="mdi mdi-pencil"></i></a>
                        <a href="javascript:;" class="action-icon" @click="deleteTicket(entrance)"> <i class="mdi mdi-delete"></i></a>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="text-center mt-2">
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
    </div>
</template>

<script>
    import LoadingComponent from '../../../components/loadingComponent'
    import swal from 'sweetalert2'

    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST, sendAPIDELETE} from "../../../vendor/common"

    export default {
        name: "Ticket",
        components: {
            LoadingComponent
        },
        data: () => ({
            isLoading: false,
            fee: false
        }),
        watch: {
            fee(value) {
                if (value !== this.event.attributes.fee_is_hidden) {
                    sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/fee`, {fee: value}).then(
                        response => {
                            this.changeEvent(response.data.data)
                        }
                    ).catch(
                        (error) => { }
                    )
                }
            }
        },
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        methods: {
            ...mapActions(['setTicket', 'changeEvent']),
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
                    this.setTicket({
                        id: ticket.id,
                        name: ticket.attributes.name,
                        free_ticket: ticket.attributes.is_free,
                        summary: ticket.attributes.description,
                        starts_at: ticket.attributes.starts_at,
                        quant_min: ticket.attributes.min_buy,
                        quant_max: ticket.attributes.max_buy,
                        lots: ticket.attributes.lots
                    })

                    this.$router.push({name: 'tickets.ticket'})
                }
            },
            deleteTicket(ticket){
                sendAPIDELETE(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/entrances`, data).then(
                    response => {
                        this.changeCart(response.data.data)
                        this.$router.push({name: 'payment'})
                    }
                ).catch(
                    (error) => {
                        if (_.isObject(error.response)) {
                            swal({
                                type: 'error',
                                title: 'Ops, algo deu errado!',
                                text: error.response.data.errors.detail
                            })
                        } else {
                            console.dir(error)
                        }
                    }
                ).finally(
                    () => {
                        Pace.stop()
                        this.isLoading = false
                    }
                )
            },
            submit() {
                this.$validator.validateAll().then(
                    async res => {
                        if (res) {
                            Pace.start()
                            this.isLoading = true

                            let data = {
                                callback: "payment",
                                tickets: this.cart.attributes.tickets,
                                _method: 'PATCH'
                            }

                            await sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/carts/${this.cart.id}/tickets`, data).then(
                                async response => {
                                    await this.changeCart(response.data.data)
                                    this.$router.push({name: 'payment'})
                                }
                            ).catch(
                                (error) => {
                                    if (_.isObject(error.response)) {
                                        swal({
                                            type: 'error',
                                            title: 'Ops, algo deu errado!',
                                            text: error.response.data.errors.detail
                                        })
                                    } else {
                                        console.dir(error)
                                    }
                                }
                            ).finally(
                                () => {
                                    Pace.stop()
                                    this.isLoading = false
                                }
                            )
                        }
                    }
                )
            }
        }
    }
</script>
