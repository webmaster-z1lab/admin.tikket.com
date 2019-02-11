<template>
    <transition name="component-fade" mode="out-in">
        <div class="col-8">
            <loading-component :is-loading="isLoading"></loading-component>

            <form class="needs-validation mt-2">
                <h4 class="header-title">Cadastro de Ingresso</h4>
                <div class="row mt-3">
                    <div class="form-group col-12">
                        <label class="col-form-label"> Nome do Ingresso <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" v-model="name"
                               :class="errors.has('name') ? 'is-invalid' : ''" v-validate="'required|max:100'"
                               data-vv-as="Nome do Evento"/>
                        <div v-show="errors.has('name')" class="invalid-feedback">
                            {{ errors.first('name') }}
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label class="col-form-label"> Breve Descrição do Ingresso</label>
                        <textarea class="form-control" name="summary" v-model="summary" :class="errors.has('summary') ? 'is-invalid' : ''" v-validate="'max:250'" data-vv-as="Breve Descrição do Evento"></textarea>
                        <div v-show="errors.has('summary')" class="invalid-feedback">
                            {{ errors.first('summary') }}
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="col-form-label"> Data de Início <span class="text-danger">*</span></label>
                        <the-mask class="form-control" type="text" name="start_date" placeholder="##/##/####"
                                  :class="errors.has('start_date') ? 'is-invalid' : ''"
                                  v-validate="'required|date_format:DD/MM/YYYY|date_before:${event.attributes.starts_at}'"
                                  data-vv-as="Data de Início" :masked="true" :mask="'##/##/####'"
                                  v-model="starts_at">
                        </the-mask>
                        <div v-show="errors.has('start_date')" class="invalid-feedback">
                            {{ errors.first('start_date') }}
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label class="col-form-label"> Quantidade Mímina <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quant_min" v-model="quant_min"
                               :class="errors.has('quant_min') ? 'is-invalid' : ''" v-validate="'required'" data-vv-as="Quantidade Mímina"/>
                        <div v-show="errors.has('quant_min')" class="invalid-feedback">
                            {{ errors.first('quant_min') }}
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label class="col-form-label"> Quantidade Máxima <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quant_max" v-model="quant_max"
                               :class="errors.has('quant_max') ? 'is-invalid' : ''" v-validate="'required'" data-vv-as="Quantidade Máxima"/>
                        <div v-show="errors.has('quant_max')" class="invalid-feedback">
                            {{ errors.first('quant_max') }}
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <h5 class="header-title mb-3">Dados de Lotes</h5>

                        <div class="form-group row mb-3">
                            <label class="col-md-2 col-form-label">Lote Único</label>
                            <div class="form-group col-md-3">
                                <label class="col-form-label"> Número de Ingressos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" v-model="name"
                                       :class="errors.has('name') ? 'is-invalid' : ''" v-validate="'required|max:100'"
                                       data-vv-as="Nome do Evento"/>
                                <div v-show="errors.has('name')" class="invalid-feedback">
                                    {{ errors.first('name') }}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="col-form-label"> Data de termino <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" v-model="name"
                                       :class="errors.has('name') ? 'is-invalid' : ''" v-validate="'required|max:100'"
                                       data-vv-as="Nome do Evento"/>
                                <div v-show="errors.has('name')" class="invalid-feedback">
                                    {{ errors.first('name') }}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="col-form-label"> Valor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" v-model="name"
                                       :class="errors.has('name') ? 'is-invalid' : ''" v-validate="'required|max:100'"
                                       data-vv-as="Nome do Evento"/>
                                <div v-show="errors.has('name')" class="invalid-feedback">
                                    {{ errors.first('name') }}
                                </div>
                            </div>
                            <p>R$200,00</p>
                        </div>
                        <button type="button" class="btn btn-success btn-block">Adicionar lote</button>
                    </div>
                </div>

                <ul class="list-inline mb-2 mt-3 wizard">
                    <li class="next list-inline-item float-right">
                        <button type="button" class="btn btn-primary" @click="submit">Salvar e Continuar</button>
                    </li>
                </ul>
            </form>
        </div>
    </transition>
</template>

<style>
    .component-fade-enter-active, .component-fade-leave-active {
        transition: opacity .3s ease;
    }
    .component-fade-enter, .component-fade-leave-to
        /* .component-fade-leave-active em versões anteriores a 2.1.8 */ {
        opacity: 0;
    }
</style>

<script>
    import LoadingComponent from '../../../components/loadingComponent'
    import swal from 'sweetalert2'

    import {TheMask} from 'vue-the-mask'
    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST} from "../../../vendor/common"
    import {VueEditor} from 'vue2-editor'

    export default {
        name: "NewTicket",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            LoadingComponent,
            TheMask,
            VueEditor
        },
        data: () => ({
            isLoading: false
        }),
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        methods: {
            ...mapActions(['changeCart']),
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
