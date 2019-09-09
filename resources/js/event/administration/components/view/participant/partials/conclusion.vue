<template>
    <div class="tab-content b-0 mb-0">
        <div class="tab-pane show active my-3">
            <div class="row" id="printable">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left mb-3">
                                     <span class="logo-invoice">
                                        <i class="fas fa-ticket-alt mr-1"></i> Tikket
                                     </span>
                                </div>
                                <div class="float-right">
                                    <h4 class="m-0 d-print-none">Pedido</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="float-left mt-3">
                                        <p>
                                            <b>Tudo certo!</b>
                                        </p>
                                        <p class="text-muted font-13">
                                            O pedido foi cadastrado com successo em nosso sistema! Para quaisquer dúvidas entre em contato com a gente utilizando um dos nossos <a
                                            class="text-dark" href="https://tikket.com.br/contato-e-suporte" target="_blank">canais de atendimento</a>.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mt-3 float-sm-right">
                                        <p class="font-13"><strong>Data do Pedido: </strong> &nbsp;&nbsp;&nbsp; {{now}}</p>
                                        <p class="font-13"><strong>Status do Pedido: </strong> <span class="badge badge-success float-right">Pago</span></p>
                                        <p class="font-13"><strong>Número do Pedido: </strong> <span class="float-right">#123456</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table mt-4">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ingresso</th>
                                                <th>Quantidade</th>
                                                <th>Preço</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(ticket, index, key) in groupTickets">
                                                <td>{{key + 1}}</td>
                                                <td>
                                                    <b>{{ticket[0].entrance_name}}</b> <br>
                                                    {{ticket[0].lot ? `Lote ${ticket[0].lot}` : '' }}
                                                </td>
                                                <td>{{ticket.length}}</td>
                                                <td>{{(ticket[0].price / 100) | currency}}</td>
                                                <td class="text-right">{{(ticket[0].price * ticket.length / 100) | currency}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="clearfix pt-3">
                                        <h6 class="text-muted">Notas:</h6>
                                        <small>
                                            Caso as informações do cliente tenham sido cadastradas no ingresso o mesmo terá todas as funcionalidades de segurança que
                                            nosso sistema oferece, deve apenas ter uma conta ou se cadastrar com uma conta no nosso sistema com o mesmo email fornecido no ingresso.
                                        </small>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="float-right mt-3 mt-sm-0">
                                        <p><b>Valor Total: </b> <span class="float-right">{{(order.attributes.amount / 100) | currency}}</span></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="d-print-none mt-4">
                                <div class="text-right">
                                    <button type="button" class="btn btn-info" onclick="window.print();return false;">
                                        <i class="mdi mdi-printer"></i> Imprimir
                                    </button>
                                    <button type="button" class="btn btn-primary" @click="resetOrder()">Novo Pedido</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .logo-invoice {
        font-size   : 2.25rem;
        font-weight : 700;
        color       : #6000A7;
    }

    @media print {
        body * {
            visibility : hidden;
        }

        #printable, #printable * {
            visibility : visible;
        }

        #printable {
            position : fixed;
            top      : 6rem;
            left     : 2rem;
        }
    }
</style>

<script>
    import moment from 'moment'

    moment.locale('pt-br');

    import {toSeek} from "../../../../../../vendor/common";
    import {mapActions, mapState} from 'vuex'

    export default {
        name: "conclusion",
        computed: {
            ...mapState({
                event: state => state.event,
                order: state => state.participant.order,
                items: state => state.participant.items
            }),
            now() {
                return moment().format('l');
            },
            year() {
                return moment().format('gggg');
            },
            groupTickets() {
                return _.groupBy(this.items, 'entrance')
            }
        },
        methods: {
            ...mapActions(['setOrder', 'setItems', 'changeEvent']),
            resetOrder() {
                this.setOrder({})
                this.setItems({})

                this.$emit('changeKey', 'choice-ticket')
            }
        },
        created() {
            toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}`).then(
                response => {
                    this.changeEvent(response.data)
                }
            )
        }
    }
</script>
