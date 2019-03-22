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
                <div class="row">
                    <div class="col-md-6 col-xl-3" v-for="(report, key) in reports">
                        {{sendReport(report)}}
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="text-muted font-weight-normal mt-0 text-truncate" :title="report.name">
                                            {{report.name}}
                                        </h5>
                                        <h3 class="my-2 py-1" v-if="report.exhibition === 'money'">{{report.value | currency}}</h3>
                                        <h3 class="my-2 py-1" v-else>{{report.value}}</h3>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right" style="position: relative;">
                                            <apexchart class="apex-charts" height="60" type="line" :options="report.options" :series="report.series"></apexchart>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert2'
    import Apexchart from 'vue-apexcharts'
    import SubHeader from '../../layouts/partials/sub-header'

    import {mapActions, mapState} from 'vuex'
    import {sendAPIDELETE, sendAPIPATCH, exceptionError, sendAlert, toSeek} from "../../../../../vendor/common";

    export default {
        name: "index",
        components: {
            SubHeader,
            Apexchart
        },
        data: () => ({
            reports: {
                sales: {
                    url: 'sales',
                    name: 'Valor das Vendas',
                    chart: 'line',
                    exhibition: 'money',
                    series: [{
                        data: []
                    }],
                    value: 0,
                    options: {
                        chart: {
                            sparkline: {
                                enabled: !0
                            }
                        },
                        stroke: {
                            width: 2,
                            curve: "smooth"
                        },
                        markers: {
                            size: 0
                        },
                        colors: ["#2dd4a4"],
                        tooltip: {
                            fixed: {
                                enabled: !1
                            },
                            x: {
                                show: !1
                            },
                            y: {
                                title: {
                                    formatter: function(e) {
                                        return ""
                                    }
                                }
                            },
                            marker: {
                                show: !1
                            }
                        }
                    }
                },
                fee: {
                    url: 'fee',
                    name: 'Valor de Repasse',
                    chart: 'line',
                    exhibition: 'money',
                    series: [{
                        data: []
                    }],
                    value: 0,
                    options: {
                        chart: {
                            sparkline: {
                                enabled: !0
                            }
                        },
                        stroke: {
                            width: 2,
                            curve: "smooth"
                        },
                        markers: {
                            size: 0
                        },
                        colors: ["#39afd1"],
                        tooltip: {
                            fixed: {
                                enabled: !1
                            },
                            x: {
                                show: !1
                            },
                            y: {
                                title: {
                                    formatter: function(e) {
                                        return ""
                                    }
                                }
                            },
                            marker: {
                                show: !1
                            }
                        }
                    }
                },
                canceled: {
                    url: 'canceled',
                    name: 'Pedidos Canceladas',
                    chart: 'line',
                    exhibition: 'int',
                    series: [{
                        data: []
                    }],
                    value: 0,
                    options: {
                        chart: {
                            sparkline: {
                                enabled: !0
                            }
                        },
                        stroke: {
                            width: 2,
                            curve: "smooth"
                        },
                        markers: {
                            size: 0
                        },
                        colors: ["#fa5c7c"],
                        tooltip: {
                            fixed: {
                                enabled: !1
                            },
                            x: {
                                show: !1
                            },
                            y: {
                                title: {
                                    formatter: function(e) {
                                        return ""
                                    }
                                }
                            },
                            marker: {
                                show: !1
                            }
                        }
                    }
                },
                tickets: {
                    url: 'sold-tickets',
                    name: 'Ingressos Vendidos',
                    chart: 'line',
                    exhibition: 'int',
                    series: [{
                        data: []
                    }],
                    value: 0,
                    options: {
                        chart: {
                            sparkline: {
                                enabled: !0
                            }
                        },
                        stroke: {
                            width: 2,
                            curve: "smooth"
                        },
                        markers: {
                            size: 0
                        },
                        colors: ["#6000a7"],
                        tooltip: {
                            fixed: {
                                enabled: !1
                            },
                            x: {
                                show: !1
                            },
                            y: {
                                title: {
                                    formatter: function(e) {
                                        return ""
                                    }
                                }
                            },
                            marker: {
                                show: !1
                            }
                        }
                    }
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
            },
            sendReport(report) {
                toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/reports/${report.url}`).then(
                    response => {
                        report.value = response.data.total
                        report.series[0].data = response.data.last_days
                    }
                )
            }
        }
    }
</script>
