<template>
    <div :class="report.col">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="text-muted font-weight-normal mt-0 text-truncate" :title="report.name">
                            <i :class="`${report.icon} mr-1`" :style="`color: ${report.color};`" v-if="report.icon"></i> {{report.name}}
                        </h5>
                        <h3 class="my-2 py-1" v-if="report.type === 'money'">{{value | currency}}</h3>
                        <h3 class="my-2 py-1" v-else>{{value}}</h3>
                    </div>
                    <div class="col-6">
                        <div class="text-right" style="position: relative;">
                            <apexchart class="apex-charts" height="60" :type="report.chart || 'line'" :options="options" :series="series"></apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Apexchart from 'vue-apexcharts'

    import {toSeek, searchID} from "../vendor/common"
    import {mapState} from 'vuex'

    export default {
        name: "ChartVue",
        props: {
            report: {
                type: [Array, Object],
                required: true
            }
        },
        components: {
            Apexchart
        },
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        data() {
            return {
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
                    colors: [this.report.color],
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
        },
        created() {
            toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/reports/${this.report.url}`).then(
                response => {
                    if (this.report.type === 'money') {
                        this.value = (response.data.total / 100)
                        this.series[0].data = _.map(response.data.last_days, function (n) {
                            return n / 100
                        })
                    } else {
                        this.value = response.data.total
                        this.series[0].data = response.data.last_days
                    }

                }
            )
        }
    }
</script>
