<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header>
                <button type="button" class="btn btn-primary" v-if="event.attributes.status === 'completed'"
                        @click="published()">Publicar Evento</button>
                <button type="button" class="btn btn-warning" v-if="event.attributes.status === 'published' && !event.attributes.is_locked"
                        @click="unpublish()">Despublicar Evento</button>
                <button type="button" class="btn btn-danger"  v-if="event.attributes.status === 'published' && event.attributes.is_locked"
                        @click="canceled()">Cancelar Evento</button>
            </sub-header>

            <div class="col-12">
                <div class="row justify-content-center">
                    <chart-component :report="report" v-for="(report, key) in reports" v-bind:key="key"></chart-component>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-right">
                            <router-link :to="{name: 'panel.edit-event'}" class="btn btn-icon btn-primary" title="Editar Dados Base do Evento">
                                <i class="fas fa-cogs"></i>
                            </router-link>
                        </div>
                        <h5 class="text-muted font-weight-bold mt-0">
                            <span class="mr-2">
                                Informações Base do Evento
                            </span>
                        </h5>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="mt-3 mb-3">{{event.attributes.name}}</h4>
                            </div>
                            <div class="col-6">
                                <h5>Status:</h5>
                                <p class="mb-0 text-muted font-weight-bold">
                                    <span class="mr-2" :class="statusEvent.color">
                                        {{statusEvent.name}}
                                    </span>
                                </p>
                                <h5>Visibilidade:</h5>
                                <p class="mb-0 text-muted font-weight-bold">
                                    <span class="mr-2" :class="event.attributes.is_public ? 'text-success' : 'text-info'">
                                        Evento {{event.attributes.is_public ? 'Público' : 'Privado'}}
                                    </span>
                                </p>
                            </div>
                            <div class="col-6">
                                <h5>Endereço:</h5>
                                <p class="mb-0 text-muted">
                                    <span class="mr-2">
                                        {{event.attributes.address.formatted}}
                                    </span>
                                </p>
                                <h5>Compartilhar:</h5>
                                <p class="mb-0 text-muted">
                                    <span class="mr-2">
                                        <button type="button" class="btn btn-icon btn-info">
                                            <i class="fab fa-facebook-f"></i>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-info">
                                            <i class="fab fa-facebook-f"></i>
                                        </button>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert2'
    import ChartComponent from '../../../../../components/chartComponent'
    import SubHeader from '../../layouts/partials/sub-header'

    import {mapActions, mapState} from 'vuex'
    import {sendAPIDELETE, sendAPIPATCH, exceptionError, sendAlert} from "../../../../../vendor/common";

    export default {
        name: "index",
        components: {
            SubHeader,
            ChartComponent
        },
        data: () => ({
            reports: {
                sales: {
                    url: 'sales',
                    col: 'col-md-6 col-xl-3',
                    name: 'Valor das Vendas',
                    chart: 'line',
                    color: '#0acf97',
                    type: 'money'
                },
                netValue: {
                    url: 'net-value',
                    col: 'col-md-6 col-xl-3',
                    name: 'Valor de Repasse',
                    chart: 'line',
                    color: '#39afd1',
                    type: 'money'
                },
                canceled: {
                    url: 'canceled',
                    col: 'col-md-6 col-xl-3',
                    name: 'Pedidos Cancelados',
                    chart: 'line',
                    color: '#fa5c7c',
                    type: 'int'
                },
                tickets: {
                    url: 'sold-tickets',
                    col: 'col-md-6 col-xl-3',
                    name: 'Ingressos Vendidos',
                    chart: 'line',
                    color: '#6000a7',
                    type: 'int'
                }
            }
        }),
        computed: {
            ...mapState({
                event: state => state.event
            }),
            statusEvent() {
                let translate = {
                    completed: {
                        name: 'Aguardando Publicação',
                        color: 'text-primary'
                    },
                    draft: {
                        name: 'Rascunho',
                        color: 'text-info'
                    },
                    finalized: {
                        name: 'Evento Finalizado',
                        color: 'text-secondary'
                    },
                    canceled: {
                        name: 'Evento Cancelado',
                        color: 'text-danger'
                    },
                    published: {
                        name: 'Evento Publicado',
                        color: 'text-success'
                    }
                }

                return translate[this.event.attributes.status]
            }
        },
        methods: {
            ...mapActions(['changeEvent', 'changeLoading']),
            canceled(){
                swal({
                    title: 'Você tem certeza?',
                    text: "Ao fazer isso seu evento não poderá ser publicado novamente e os participantes já inscritos terão de ser reembolsados! " +
                        "Se deseja continuar digite abaixo o nome do evento.",
                    type: 'warning',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Cancelar Evento',
                    confirmButtonColor: '#d33',
                }).then((result) => {
                    if (result.value) {
                        if (result.value === this.event.attributes.name) {
                            this.changeLoading(true)

                            sendAPIDELETE(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}`, {})
                                .then(response => {
                                    this.changeLoading(false)
                                    this.changeEvent(response.data.data)

                                    swal({
                                        title: 'Evento Cancelado',
                                        type: 'success',
                                        text: "Seu Evento foi cancelado, entre com contato conosco para receber mais informações e ajuda para realizar os procedimentos finais de cancelamento do seu evento! "
                                    })
                                })
                                .catch((error) => {
                                    this.changeLoading(false)
                                    exceptionError(error)
                                })

                        } else {
                            swal({
                                title: 'Evento Não foi Cancelado',
                                type: 'error',
                                text: "O nome inserido no campo não é o mesmo do evento resgistrado."
                            })
                        }
                    }
                })
            },
            published() {
                this.changeLoading(true)

                sendAPIPATCH(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/publish`, {})
                    .then(response => {
                        this.changeLoading(false)
                        this.changeEvent(response.data.data)

                        sendAlert({
                            title: 'Tudo Certo!',
                            message: 'Evendo Publicado com Sucesso.',
                            type: 'success'
                        })
                    })
                    .catch((error) => {
                        this.changeLoading(false)
                        exceptionError(error)
                    })
            },
            unpublish() {
                swal({
                    title: 'Você tem certeza?',
                    text: "Ao fazer isso seu evento não poderá ter incrições nem será encontrado em nosso site!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, Despublicar!'
                }).then((result) => {
                    if (result.value) {
                        this.changeLoading(true)

                        sendAPIDELETE(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}`, {})
                            .then(response => {
                                this.changeLoading(false)
                                this.changeEvent(response.data.data)

                                sendAlert({
                                    title: 'Tudo Certo!',
                                    message: 'Evento foi Despublicado. Caso deseje poderá publica-lo novamente!',
                                    type: 'success'
                                })
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
