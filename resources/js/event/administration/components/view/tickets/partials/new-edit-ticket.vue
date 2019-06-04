<template>
    <transition name="slide-fade">
        <div class="card-body">
            <h4 class="header-title">{{ticket.id === null ? 'Cadastro de Ingresso' : ticket.name}}</h4>

            <form class="needs-validation mt-2">
                <div class="row mt-3">
                    <div class="form-group" :class="ticket.free_ticket ? 'col-md-8' : 'col-md-10'">
                        <label class="col-form-label"> Nome do Ingresso <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" v-model="ticket.name"
                               v-bind:disabled="ticket.is_locked"
                               :class="errors.has('name') ? 'is-invalid' : ''" v-validate="'required|max:50'"
                               data-vv-as="Nome do Evento"/>
                        <div v-show="errors.has('name')" class="invalid-feedback">
                            {{ errors.first('name') }}
                        </div>
                    </div>

                    <div class="form-group col-md-2" v-if="ticket.free_ticket">
                        <label class="col-form-label"> Quant. de Ingressos <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="ticket_amount" v-model="ticket.lots[0].amount"
                               :class="errors.has('ticket_amount') ? 'is-invalid' : ''" v-validate="'required'"
                               data-vv-as="Quant. de Ingressos"/>
                        <div v-show="errors.has('ticket_amount')" class="invalid-feedback">
                            {{ errors.first('ticket_amount') }}
                        </div>
                    </div>

                    <div class="form-group col-md-2" v-if="!ticket.is_locked">
                        <label class="col-form-label"> Ingresso Grátis </label>
                        <div class="custom-control custom-checkbox form-custom" style="padding-left: 0">
                            <input type="checkbox" id="switch1" data-switch="bool" name="free_ticket"
                                   v-model="ticket.free_ticket">
                            <label for="switch1" data-on-label="Sim" data-off-label="Não"></label>
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label class="col-form-label"> Breve Descrição do Ingresso </label>
                        <textarea class="form-control" name="summary" v-model="ticket.summary"
                                  :class="errors.has('summary') ? 'is-invalid' : ''" v-validate="'max:100'"
                                  data-vv-as="Breve Descrição do Evento"></textarea>
                        <div v-show="errors.has('summary')" class="invalid-feedback">
                            {{ errors.first('summary') }}
                        </div>
                    </div>

                    <div class="form-group" :class="ticket.free_ticket ? 'col-md-3' : 'col-md-4'">
                        <label class="col-form-label"> Início das Vendas <span class="text-danger">*</span></label>
                        <the-mask class="form-control" type="text" name="start_date" placeholder="##/##/####"
                                  :class="errors.has('start_date') ? 'is-invalid' : ''"
                                  v-bind:disabled="inArr(['published', 'canceled', 'finalized'], event.attributes.status) && ticket.is_locked"
                                  v-validate="`required|date_format:dd/MM/yyyy|date_before:${event.attributes.starts_at}|today_off_time`"
                                  data-vv-as="Início das Vendas" :masked="true" :mask="'##/##/####'"
                                  v-model="ticket.starts_at">
                        </the-mask>
                        <div v-show="errors.has('start_date')" class="invalid-feedback">
                            {{ errors.first('start_date') }}
                        </div>
                    </div>

                    <div class="form-group col-md-3" v-if="ticket.free_ticket">
                        <label class="col-form-label"> Fim das Vendas <span class="text-danger">*</span></label>
                        <the-mask class="form-control" type="text" name="end_at" placeholder="##/##/####"
                                  :class="errors.has('end_at') ? 'is-invalid' : ''"
                                  v-validate="`required|date_format:dd/MM/yyyy|date_before:${event.attributes.starts_at}|date_after:${ticket.starts_at}`"
                                  data-vv-as="'Fim das Vendas'" :masked="true" :mask="'##/##/####'"
                                  v-bind:disabled="inArr(['published', 'canceled', 'finalized'], event.attributes.status)"
                                  v-model="ticket.lots[0].finishes_at"/>
                        <div v-show="errors.has('end_at')" class="invalid-feedback">
                            {{ errors.first('end_at') }}
                        </div>
                    </div>

                    <div class="form-group" :class="ticket.free_ticket ? 'col-md-3' : 'col-md-4'">
                        <label class="col-form-label"> Quantidade Mímina <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quant_min" v-model="ticket.quant_min"
                               v-bind:disabled="ticket.is_locked"
                               :class="errors.has('quant_min') ? 'is-invalid' : ''" v-validate="'required|min_value:1'"
                               data-vv-as="Quantidade Mímina"/>
                        <div v-show="errors.has('quant_min')" class="invalid-feedback">
                            {{ errors.first('quant_min') }}
                        </div>
                    </div>

                    <div class="form-group" :class="ticket.free_ticket ? 'col-md-3' : 'col-md-4'">
                        <label class="col-form-label"> Quantidade Máxima <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quant_max" v-model="ticket.quant_max"
                               v-bind:disabled="ticket.is_locked"
                               :class="errors.has('quant_max') ? 'is-invalid' : ''" v-validate="'required|min_value:1'"
                               data-vv-as="Quantidade Máxima"/>
                        <div v-show="errors.has('quant_max')" class="invalid-feedback">
                            {{ errors.first('quant_max') }}
                        </div>
                    </div>

                    <div class="col-12 mt-3" v-if="!ticket.free_ticket">
                        <h5 class="header-title mb-3">Dados de Lotes</h5>

                        <div class="form-group row mb-3" v-for="(lot, index) in ticket.lots">
                            <label class="col-md-1 col-form-label align-self-center">
                                {{ticket.lots.length > 1 ? `Lote ${index + 1}` : 'Lote Único'}}
                            </label>
                            <div class="form-group col-md-2">
                                <label class="col-form-label"> Quant. de Ingressos <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" :name="`ticket_amount-${index}`"
                                       v-model="lot.amount"
                                       :class="errors.has(`ticket_amount-${index}`) ? 'is-invalid' : ''"
                                       v-bind:disabled="inArr(['closed', 'expired'], lot.status)"
                                       v-validate="'required|min_value:1'" data-vv-as="Quant. de Ingressos"/>
                                <div v-show="errors.has(`ticket_amount-${index}`)" class="invalid-feedback">
                                    {{ errors.first(`ticket_amount-${index}`) }}
                                </div>
                            </div>
                            <div class="form-group col-md-3" v-if="index <= 0">
                                <label class="col-form-label"> Fim das Vendas<span class="text-danger">*</span></label>
                                <the-mask class="form-control" type="text" :name="`end_at-${index}`"
                                          placeholder="##/##/####"
                                          :class="errors.has(`end_at-${index}`) ? 'is-invalid' : ''"
                                          v-validate="`required|date_format:dd/MM/yyyy|date_before:${event.attributes.starts_at}|date_after:${ticket.starts_at}`"
                                          v-bind:disabled="inArr(['closed', 'expired', 'locked'], lot.status)"
                                          data-vv-as="'Fim das Vendas'" :masked="true" :mask="'##/##/####'"
                                          v-model="lot.finishes_at"/>
                                <div v-show="errors.has(`end_at-${index}`)" class="invalid-feedback">
                                    {{ errors.first(`end_at-${index}`) }}
                                </div>
                            </div>
                            <div class="form-group col-md-3" v-else>
                                <label class="col-form-label"> Fim das Vendas <span class="text-danger">*</span></label>
                                <the-mask class="form-control" type="text" :name="`end_at-${index}`"
                                          placeholder="##/##/####"
                                          :class="errors.has(`end_at-${index}`) ? 'is-invalid' : ''"
                                          v-validate="`required|date_format:dd/MM/yyyy|date_before:${event.attributes.starts_at}|date_after:${ticket.lots[(index - 1)].finishes_at}`"
                                          v-bind:disabled="inArr(['closed', 'expired', 'locked'], lot.status)"
                                          data-vv-as="'Fim das Vendas'" :masked="true" :mask="'##/##/####'"
                                          v-model="lot.finishes_at"/>
                                <div v-show="errors.has(`end_at-${index}`)" class="invalid-feedback">
                                    {{ errors.first(`end_at-${index}`) }}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="col-form-label"> Valor do Ingresso <span class="text-danger">*</span></label>
                                <money class="form-control" v-model="lot.value" v-bind="money_format"
                                       v-validate="'required|min_value:1'" data-vv-as="Valor"
                                       :class="errors.has(`ticket_value-${index}`) ? 'is-invalid' : ''"
                                       v-bind:disabled="lot.status !== 'open'"
                                       :name="`ticket_value-${index}`"/>
                                <div v-show="errors.has(`ticket_value-${index}`)" class="invalid-feedback">
                                    {{ errors.first(`ticket_value-${index}`) }}
                                </div>
                            </div>
                            <div class="form-group col-md-2 align-self-center text-center" v-if="event.attributes.fee_is_hidden">
                                <label class="col-form-label"> Valor Final </label>
                                <h5 class="text-success">{{amount_ticket(lot.value).amount | currency}}</h5>
                            </div>
                            <div class="form-group col-md-2 align-self-center text-center" v-else>
                                <label class="col-form-label"> Valor Final </label>
                                <h5 class="text-success">
                                    {{amount_ticket(lot.value).value | currency}} (+ taxa de serviço de {{(amount_ticket(lot.value).fee / 100) | currency }})
                                </h5>
                            </div>
                            <div class="col-md-1 align-self-center" v-if="lot.status === 'open'">
                                <button type="button" class="btn btn-danger btn-block" v-if="index > 0" @click="removeLot(index)">
                                    <i class="far fa-times-circle"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-block" @click="addLot">Adicionar novo lote</button>
                    </div>
                </div>

                <ul class="list-inline mb-2 mt-3 wizard">
                    <li class="next list-inline-item float-right">
                        <button type="button" class="btn btn-warning" @click="$emit('changePage', 'tickets')">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="submit">Salvar</button>
                    </li>
                </ul>
            </form>
        </div>
    </transition>
</template>

<style>
    /* Animações de entrada e saída podem utilizar diferentes  */
    /* funções de duração e de tempo.                          */
    .slide-fade-enter-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-leave-active {
        transition: all .0s ease;
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active em versões anteriores a 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }
</style>

<script>
    import moment from 'moment'

    import {TheMask} from 'vue-the-mask'
    import {Money} from 'v-money'
    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST, exceptionError, sendAlert} from "../../../../../../vendor/common"

    export default {
        name: "newEditTicket",
        inject: ['$validator'],
        components: {
            TheMask,
            Money
        },
        data: () => ({
            money_format: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                suffix: '',
                precision: 2,
                masked: false
            },
        }),
        computed: {
            ...mapState({
                event: state => state.event,
                ticket: state => state.tickets.ticket
            })
        },
        methods: {
            ...mapActions(['changeEvent', 'changeLoading']),
            inArr(arr, string){
                return arr.indexOf(string) !== -1
            },
            addLot() {
                this.ticket.lots.push({
                    status: 'open',
                    ticket_amount: 0,
                    finishes_at: '',
                    ticket_value: 0
                })
            },
            removeLot(key) {
                this.ticket.lots.splice(key, 1)
            },
            amount_ticket(value) {
                if(value <= 0) {
                    return {
                        amount: 0,
                        value: 0,
                        fee: 0
                    }
                }

                if (value <= process.env.MIX_MIN_VALUE_FEE) {
                    return {
                        amount: (value + (process.env.MIX_MIN_VALUE_FEE * 10 / 100)),
                        value: value,
                        fee: process.env.MIX_MIN_VALUE_FEE * 10 / 100
                    }
                } else {
                    return {
                        amount: (value * 10 / 100) + value,
                        value: value,
                        fee: value * 10 / 100
                    }
                }
            },
            submit() {
                this.$validator.validateAll().then(
                    async res => {
                        if (res) {
                            this.changeLoading(true)

                            let edit_ticket = _.isNull(this.ticket.id),
                                route_continue = edit_ticket ? '' : `/${this.ticket.id}`,
                                data = {
                                name: this.ticket.name,
                                is_free: this.ticket.free_ticket,
                                max_buy: parseInt(this.ticket.quant_max),
                                min_buy: parseInt(this.ticket.quant_min),
                                description: this.ticket.summary,
                                starts_at: moment(this.ticket.starts_at, 'DD/MM/YYYY').format('YYYY-MM-DD'),
                                lots: this.formatLot(this.ticket.lots, this.ticket.free_ticket),
                                _method: edit_ticket ? 'POST' : 'PATCH'
                            }

                            await sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/entrances${route_continue}`, data)
                                .then(async response => {
                                    await this.changeEvent(response.data.data)

                                    sendAlert({
                                        title: 'Tudo Certo!',
                                        message: `Ingresso ${edit_ticket ? 'Criado' : 'Editado'} com sucesso.`,
                                        type: 'success'
                                    })

                                    this.$emit('changePage', 'tickets')
                                })
                                .catch((error) => {
                                    this.changeLoading(false)
                                    exceptionError(error)
                                })
                        }
                    }
                )
            },
            formatLot(lots, free){
                let arr = []

                console.log(free)

                for(let value in lots) {
                    arr.push({
                        amount:  lots[value].amount,
                        finishes_at: moment(lots[value].finishes_at, 'DD/MM/YYYY').format('YYYY-MM-DD'),
                        value: !free ? lots[value].value : null
                    })
                }

                return arr
            }
        }
    }
</script>
