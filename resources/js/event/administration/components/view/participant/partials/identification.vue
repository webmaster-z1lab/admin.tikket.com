<template>
    <div class="tab-content b-0 mb-0">
        <div class="tab-pane show active my-3">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="card" v-for="(item, index) in items">
                        <div class="card-body">
                            <h4 class="header-title">Ingresso nº {{ index + 1}}</h4>
                            <p class="text-muted">
                                {{ item.entrance_name }} - {{ item.lot ? `Lote ${item.lot}` : '' }}
                            </p>

                            <div class="alert alert-primary" role="alert">
                                <h4 class="alert-heading">Informações do Cliente</h4>
                                <p>
                                    Caso as informações do cliente sejam cadastradas no ingresso o mesmo terá todas as funcionalidades de segurança que o Tikket oferece. Para acesso ao ingresso digital basta o cliente se cadastrar no nosso site utilizando as mesmas informações fornecidas no cadastro abaixo.
                                </p>
                            </div>



                            <form>
                                <div class="form-group mb-3">
                                    <label>Código do Ingresso (utilizado para identificação na portaria) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" :name="`code-${index}`"
                                           v-model="item.code" data-vv-as="Código do Ingresso"
                                           placeholder="Ex: 123456789"
                                           :class="errors.has(`code-${index}`) ? 'is-invalid' : ''" v-validate="'required'">
                                    <div v-show="errors.has(`code-${index}`)" class="invalid-feedback">
                                        {{ errors.first(`code-${index}`) }}
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Nome do cliente</label>
                                    <input type="text" class="form-control" :name="`name-${index}`" @change="validateAll(item, item.name)"
                                           placeholder="Ex: João das Neves"
                                           v-model="item.name" data-vv-as="Nome"
                                           :class="errors.has(`name-${index}`) ? 'is-invalid' : ''" v-validate="`${item.validate_user}`">
                                    <div v-show="errors.has(`name-${index}`)" class="invalid-feedback">
                                        {{ errors.first(`name-${index}`) }}
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>E-mail do cliente</label>
                                    <input type="email" class="form-control" :name="`email-${index}`" @change="validateAll(item, item.email)"
                                           placeholder="Ex: joao@email.com.br"
                                           v-model="item.email" data-vv-as="Email"
                                           :class="errors.has(`email-${index}`) ? 'is-invalid' : ''" v-validate="`${item.validate_user}email`">
                                    <div v-show="errors.has(`email-${index}`)" class="invalid-feedback">
                                        {{ errors.first(`email-${index}`) }}
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>CPF do cliente</label>
                                    <the-mask class="form-control" type="text" :name="`document-${index}`" placeholder="000.000.000-00"
                                              @change="validateAll(item, item.document)" v-validate="`${item.validate_user}cpf`"
                                              data-vv-as="'CPF'" mask="###.###.###-##" v-model="item.document" :class="errors.has(`document-${index}`) ? 'is-invalid' : ''">
                                    </the-mask>
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

    import {TheMask} from 'vue-the-mask'
    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST, exceptionError, sendAlert} from "../../../../../../vendor/common";

    export default {
        name: "identification",
        inject: ['$validator'],
        components: {
            TheMask
        },
        computed: {
            ...mapState({
                event: state => state.event,
                items: state => state.participant.items
            })
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
