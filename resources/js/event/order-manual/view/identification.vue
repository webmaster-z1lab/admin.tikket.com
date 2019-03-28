<template>
    <div class="tab-content b-0 mb-0">
        <div class="tab-pane show active my-3">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="text-center my-4">
                        <h2 class="mt-0"><i class="fas fa-money-bill"></i></h2>
                        <h4 class="mt-0">Valor do Pedido: {{ (amountOrder / 100) | currency}}</h4>
                    </div>

                    <div class="card" v-for="(item, index) in items">
                        <div class="card-body">
                            <h4 class="header-title">Ingresso nº {{ index + 1}}</h4>
                            <p class="text-muted">
                                {{ item.entrance_name }} - {{ item.lot ? `Lote ${item.lot}` : '' }}
                            </p>

                            <form>
                                <div class="form-group mb-3">
                                    <label>Código do Ingresso <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" :name="`code-${index}`"
                                           v-model="item.code" data-vv-as="Código do Ingresso"
                                           :class="errors.has(`code-${index}`) ? 'is-invalid' : ''" v-validate="'required'">
                                    <div v-show="errors.has(`code-${index}`)" class="invalid-feedback">
                                        {{ errors.first(`code-${index}`) }}
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" :name="`name-${index}`" @change="validateAll(item, item.name)"
                                           v-model="item.name" data-vv-as="Nome"
                                           :class="errors.has(`name-${index}`) ? 'is-invalid' : ''" v-validate="`${item.validate_user}`">
                                    <div v-show="errors.has(`name-${index}`)" class="invalid-feedback">
                                        {{ errors.first(`name-${index}`) }}
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" :name="`email-${index}`" @change="validateAll(item, item.email)"
                                           v-model="item.email" data-vv-as="Email"
                                           :class="errors.has(`email-${index}`) ? 'is-invalid' : ''" v-validate="`${item.validate_user}email`">
                                    <div v-show="errors.has(`email-${index}`)" class="invalid-feedback">
                                        {{ errors.first(`email-${index}`) }}
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>CPF</label>
                                    <input type="text" class="form-control" :name="`document-${index}`" @change="validateAll(item, item.document)"
                                           v-model="item.document" data-vv-as="CPF"
                                           :class="errors.has(`document-${index}`) ? 'is-invalid' : ''" v-validate="`${item.validate_user}document`">
                                    <div v-show="errors.has(`document-${index}`)" class="invalid-feedback">
                                        {{ errors.first(`document-${index}`) }}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ul class="list-inline wizard mb-0">
            <li class="previous list-inline-item">
                <button type="button" class="btn btn-warning" @click="canceledOrder">Cancelar</button>
            </li>
            <li class="next list-inline-item float-right">
                <button type="button" class="btn btn-primary" @click="nextOrder">Continuar</button>
            </li>
        </ul>
    </div>
</template>

<script>
    import swal from 'sweetalert2'

    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST, exceptionError, sendAlert} from "../../../vendor/common";

    export default {
        name: "identification",
        inject: ['$validator'],
        data: () => ({

        }),
        computed: {
            ...mapState({
                event: state => state.event,
                items: state => state.items
            }),
            amountOrder() {
                return _.sumBy(this.items, 'price')
            }
        },
        methods: {
            ...mapActions(['changeLoading', 'setOrder', 'setItems']),
            validateAll(item, value) {
                _.isEmpty(value) ? item.validate_user = '' : item.validate_user = 'required|'
            },
            canceledOrder() {
                swal({
                    title: 'Você tem certeza?',
                    text: "Ao fazer isso você perderá todo o progresso de cadastro!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, apagar!'
                }).then((result) => {
                    if (result.value) {
                        sendAlert({
                            title: 'Tudo Certo!',
                            message: 'Pedido Cancelado.',
                            type: 'success'
                        })

                        this.items = []
                        this.setItems({})

                        this.$emit('changeKey', 'choice-ticket')
                    }
                })

            },
            nextOrder() {
                this.$validator.validateAll().then(
                    async res => {
                        if (res) {
                            this.changeLoading(true)

                            let data = {
                                event: this.event.id,
                                tickets: this.items
                            }

                            sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/sales`, data)
                                .then(response => {
                                    sendAlert({
                                        title: 'Tudo Certo!',
                                        message: 'Pedido finalizado com sucesso.',
                                        type: 'success'
                                    })

                                    this.setOrder(response.data.data)

                                    this.changeLoading(false)
                                    this.$emit('changeKey', 'conclusion')
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
