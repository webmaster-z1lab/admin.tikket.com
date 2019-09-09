<template>
    <transition name="slide-fade">
        <div class="card-body">
            <h4 class="header-title">{{coupon.id === null ? 'Cadastro de Cupom' : coupon.tag}}</h4>

            <div class="alert alert-primary" role="alert">
                <h4 class="alert-heading">Taxa de serviço</h4>

                <p>
                    Os cupons de desconto são aplicados sobre o valor total do ingresso referenciado porém não altera o valor da taxa de 10% cobrada pelo Tikket, que é calculada
                    sobre o valor integral de cada ingresso.
                </p>
            </div>

            <form class="needs-validation mt-2">
                <div class="row mt-3">
                    <div class="form-group col-md-5">
                        <label class="col-form-label">Tag <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tag" v-model="coupon.tag"
                               placeholder="Nome fácil para reconhecimento"
                               :class="errors.has('tag') ? 'is-invalid' : ''" v-validate="'required|max:50'" data-vv-as="Tag"/>
                        <div v-show="errors.has('tag')" class="invalid-feedback">
                            {{ errors.first('tag') }}
                        </div>
                    </div>

                    <div class="form-group col-md-5">
                        <label class="col-form-label">Data de Validade <span class="text-danger">*</span></label>
                        <the-mask class="form-control" type="text" name="validate_at" placeholder="DD/MM/AAAA"
                                  :class="errors.has('validate_at') ? 'is-invalid' : ''"
                                  v-validate="`required|date_format:dd/MM/yyyy|today`"
                                  data-vv-as="Data de Validade" :masked="true" :mask="'##/##/####'"
                                  v-model="coupon.validate_at">
                        </the-mask>
                        <div v-show="errors.has('validate_at')" class="invalid-feedback">
                            {{ errors.first('validate_at') }}
                        </div>
                    </div>

                    <div class="form-group col-md-2" v-if="!coupon.is_locked">
                        <label class="col-form-label"> Tipo de desconto</label>
                        <div class="custom-control custom-checkbox form-custom" style="padding-left: 0">
                            <input type="checkbox" id="switch1" data-switch="bool" name="is_percentage" v-model="coupon.is_percentage">
                            <label for="switch1" data-on-label="%" data-off-label="$"></label>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="col-form-label"> {{coupon.is_percentage ? "Desconto em Porcentagem" : "Desconto em Valor"}} <span class="text-danger">*</span></label>
                        <money class="form-control" v-model="coupon.discount" v-bind="format_discount"
                               v-bind:disabled="coupon.is_locked"
                               v-validate="'required|min_value:1'" data-vv-as="Desconto" :class="errors.has('discount') ? 'is-invalid' : ''" name="discount"/>
                        <div v-show="errors.has('discount')" class="invalid-feedback">
                            {{ errors.first('discount') }}
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="col-form-label"> Referente ao Ingresso <span class="text-danger">*</span></label>
                        <select class="form-control" name="entrance_id" :class="errors.has('entrance_id') ? 'is-invalid' : ''"
                                v-bind:disabled="coupon.is_locked"
                                v-validate="'required'" data-vv-as="Referente ao Ingresso" v-model="coupon.entrance_id">
                            <option selected value="">Selecione um Ingresso</option>
                            <option v-for="entrances in event.relationships.entrances" :value="entrances.id">{{entrances.attributes.name}}</option>
                        </select>
                        <div v-show="errors.has('entrance_id')" class="invalid-feedback">
                            {{ errors.first('entrance_id') }}
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="col-form-label">Reutilização <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="reuse" v-model="coupon.reuse"
                               :class="errors.has('reuse') ? 'is-invalid' : ''" v-validate="'required|min_value:1'"
                               data-vv-as="Reutilização"/>
                        <div v-show="errors.has('reuse')" class="invalid-feedback">
                            {{ errors.first('reuse') }}
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="col-form-label">Código <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="code" v-model="coupon.code"
                               v-bind:disabled="coupon.is_locked"
                               :class="errors.has('code') ? 'is-invalid' : ''" v-validate="'required'" data-vv-as="Código"/>
                        <div v-show="errors.has('code')" class="invalid-feedback">
                            {{ errors.first('code') }}
                        </div>
                    </div>
                </div>

                <ul class="list-inline mb-2 mt-3 wizard">
                    <li class="next list-inline-item float-right">
                        <button type="button" class="btn btn-warning" @click="$emit('changePage', 'coupons')">Cancelar</button>
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
        transition : all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }

    .slide-fade-leave-active {
        transition : all .0s ease;
    }

    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active em versões anteriores a 2.1.8 */ {
        transform : translateX(10px);
        opacity   : 0;
    }
</style>

<script>
    import moment from 'moment'

    import {TheMask} from 'vue-the-mask'
    import {Money} from 'v-money'
    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST, exceptionError, sendAlert} from "../../../../../../vendor/common"

    export default {
        name: "newEditCoupon",
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
            porcentage_format: {
                decimal: '',
                thousands: '',
                prefix: '',
                suffix: ' %',
                precision: 0,
                masked: false
            }
        }),
        computed: {
            ...mapState({
                event: state => state.event,
                coupon: state => state.tickets.coupon
            }),
            format_discount() {
                return this.coupon.is_percentage ? this.porcentage_format : this.money_format
            }
        },
        methods: {
            ...mapActions(['setCoupons', 'changeLoading']),
            submit() {
                this.$validator.validateAll().then(
                    async res => {
                        if (res) {
                            this.changeLoading(true)

                            let edit_coupon = _.isNull(this.coupon.id),
                                route_continue = edit_coupon ? '' : `/${this.coupon.id}`,

                                data = {
                                    name: this.coupon.tag,
                                    is_percentage: this.coupon.is_percentage,
                                    valid_until: moment(this.coupon.validate_at, 'DD/MM/YYYY').format('YYYY-MM-DD'),
                                    code: this.coupon.code,
                                    discount: parseInt(this.coupon.discount),
                                    quantity: parseInt(this.coupon.reuse),
                                    entrance_id: this.coupon.entrance_id,
                                    _method: edit_coupon ? 'POST' : 'PATCH'
                                }

                            await sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/coupons${route_continue}`, data)
                                .then(async response => {
                                    await this.setCoupons(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/coupons`)

                                    sendAlert({
                                        title: 'Tudo Certo!',
                                        message: `Cupom ${edit_coupon ? 'Criado' : 'Editado'} com sucesso.`,
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
            }
        }
    }
</script>
