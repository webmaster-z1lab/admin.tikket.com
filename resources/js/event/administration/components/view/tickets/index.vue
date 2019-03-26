<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header />

            <div class="col-12">
                <div class="row">
                    <div class="col-md-4" v-for="(report, key) in reports">
                        {{sendReport(report)}}
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="text-muted font-weight-normal mt-0 text-truncate" :title="report.name">
                                            <i class="fas fa-ticket-alt mr-1" :style="`color: ${report.color};`"></i> {{report.name}}
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

            <div class="col-12">
                <div class="card">
                    <component :is="page" @changePage="changePage"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import Apexchart from 'vue-apexcharts'
    import Tickets from './partials/tickets'
    import NewEditTicket from './partials/new-edit-ticket'

    import {mapState} from 'vuex'
    import {toSeek} from "../../../../../vendor/common";

    export default {
        name: "index",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            SubHeader,
            Tickets,
            NewEditTicket,
            Apexchart
        },
        data: () => ({
            page: 'tickets',
            reports: {
                sold: {
                    url: 'sold-tickets',
                    name: 'Ingressos Vendidos',
                    color: '#0acf97',
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
                        colors: ["#0acf97"],
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
                    url: 'pending-tickets',
                    name: 'Ingressos Pendentes',
                    color: '#ffbc00',
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
                        colors: ["#ffbc00"],
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
                    url: 'canceled-tickets',
                    name: 'Ingressos Cancelados',
                    color: '#fa5c7c',
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
                }
            }
        }),
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        methods: {
            changePage(page) {
                this.page = page
            },
            sendReport(report) {
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
    }
</script>
