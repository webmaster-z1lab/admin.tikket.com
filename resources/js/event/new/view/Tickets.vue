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

        <p class="text-muted font-14 mb-4">
            haha
        </p>

        <div class="table-responsive-sm mt-3">
            <table class="table table-striped table-centered mb-0">
                <thead>
                <tr>
                    <th>Nome do Ingresso</th>
                    <th>Valor</th>
                    <th>Taxa</th>
                    <th>Preço Final</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr>
                <!--<tr>-->
                    <!--<td>asasas</td>-->
                    <!--<td>1289804962</td>-->
                    <!--<td>asssas</td>-->
                    <!--<td class="table-action text-center">-->
                        <!--<a href="" class="action-icon"> <i class="mdi mdi-eye"></i></a>-->
                        <!--<a href="" class="action-icon"> <i class="mdi mdi-pencil"></i></a>-->
                        <!--<a href="javascript:;" class="action-icon"> <i class="mdi mdi-delete"></i></a>-->
                    <!--</td>-->
                <!--</tr>-->
                </tbody>
            </table>

            <div class="text-center mt-2">
                <figure class="mx-auto mb-4">
                    <img src="https://cdn.z1lab.com.br/images/undraw/undraw_analysis_4jis.svg" alt="SVG" width="20%">
                </figure>

                <div class="mb-4">
                    <h1 class="h3"><strong>Nenhum ingresso cadastrado</strong></h1>

                    <p class="h5">Para continuar você precisa ter pelo menos um ingresso cadastrado!</p>

                    <router-link :to="{name: 'company_registration'}" class="btn btn-icon btn-primary">
                        Adicionar Ingresso
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from '../../../components/loadingComponent'
    import swal from 'sweetalert2'

    import {TheMask} from 'vue-the-mask'
    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST} from "../../../vendor/common"
    import {VueEditor} from 'vue2-editor'

    export default {
        name: "Ticket",
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
            ...mapActions(['setTicket']),
            ticket(new_ticket, ticket) {
                if (new_ticket) {
                    this.$router.push({name: 'tickets.ticket'})
                } else {

                }
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
