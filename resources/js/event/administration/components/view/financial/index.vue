<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header />

            <div class="col-12">
                <div class="row">
                    <div class="col-md-3" v-for="report in reports">
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
                </div>
            </div>

            <div class="col-4">
                <h1>assa</h1>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Histórico de Pedidos</h4>

                        <paginator :active="showPaginate" :meta="paginate.meta" :links="paginate.links" @changePaginate="changePaginate">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xl-4">
                                    <div class="form-group mb-3">
                                        <label for="search">Pesquisar</label>
                                        <input type="text" id="search" class="form-control" placeholder="Cod. Pedido, Nome e Email" v-model.lazy="search">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12">
                                    <table class="table table-hover table-centered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Comprador</th>
                                            <th>Cod. Pedido</th>
                                            <th>Forma de Compra</th>
                                            <th>Data da Compra</th>
                                            <th>Valor</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="value in paginate.data">
                                            <td>
                                                <i class="mdi mdi-circle ml-1" :class="colorStatus(value.status)"></i>
                                            </td>
                                            <td>{{value.name}}</td>
                                            <td>{{value.order}}</td>
                                            <td>{{translateTypeBuy(value.channel)}}</td>
                                            <td>{{value.created_at}}</td>
                                            <td>{{(value.price / 100) | currency}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </paginator>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import Paginator from '../../../../../components/datatable/paginator'
    import Apexchart from 'vue-apexcharts'

    import {toSeek} from "../../../../../vendor/common";
    import {mapActions, mapState} from 'vuex'

    export default {
        name: "index",
        components: {
            SubHeader,
            Paginator,
            Apexchart
        },
        data: () => ({
            paginate: {},
            search: '',
            reports: {
                sales: {
                    url: 'sales',
                    name: 'Total das Vendas',
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
                netValue: {
                    url: 'net-value',
                    name: 'Total para Repasse',
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
                pending: {
                    url: 'pending-values',
                    name: 'Vendas Pendentes',
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
                },
                canceled: {
                    url: 'canceled-values',
                    name: 'Total de Cancelados',
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
            }
        }),
        watch: {
            search(value) {
                let params = null

                if(value !== '') params = {search: value}

                toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/reports/orders`, params).then(
                    response => {
                        this.changePaginate(response)
                    }
                )
            }
        },
        computed: {
            ...mapState({
                event: state => state.event
            }),
            showPaginate() {
                return this.search !== ''
            }
        },
        methods: {
            ...mapActions(['changeEvent']),
            changePaginate(paginate) {
                this.paginate = paginate
            },
            colorStatus(status) {
                let obj = {
                    paid: 'text-success',
                    canceled: 'text-danger',
                    waiting: 'text-warning'
                }

                return obj[status]
            },
            translateTypeBuy(type) {
                let obj = {
                    admin: 'Incrição de Administrador',
                    pdv: 'Incrição PVD',
                    online: 'Incrição Online'
                }

                return obj[type]
            },
            sendReport(report) {
                if (_.isEmpty(report.series[0].data)) {
                    toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/reports/${report.url}`).then(
                        response => {
                            if (report.exhibition === 'money') {
                                report.value = (response.data.total / 100)
                                report.series[0].data = _.map(response.data.last_days, function (n) {
                                    return n / 100
                                })
                            } else {
                                report.value = response.data.total
                                report.series[0].data = response.data.last_days
                            }
                        }
                    )
                }
            }
        },
        mounted() {
            toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/reports/orders`).then(
                response => {
                    this.changePaginate(response)
                }
            )
        }
    }
</script>
