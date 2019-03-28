<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header />

            <div class="col-12">
                <div class="row justify-content-center">
                    <chart-component :report="report" v-for="(report, key) in reports" v-bind:key="key"></chart-component>
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
    import ChartComponent from '../../../../../components/chartComponent'
    import Tickets from './partials/tickets'
    import NewEditTicket from './partials/new-edit-ticket'

    export default {
        name: "index",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            SubHeader,
            Tickets,
            NewEditTicket,
            ChartComponent
        },
        data: () => ({
            page: 'tickets',
            reports: {
                sold: {
                    url: 'sold-tickets',
                    col: 'col-4',
                    icon: 'fas fa-ticket-alt',
                    name: 'Ingressos Vendidos',
                    color: '#0acf97',
                    chart: 'line',
                    type: 'int'
                },
                pending: {
                    url: 'pending-tickets',
                    col: 'col-4',
                    icon: 'fas fa-ticket-alt',
                    name: 'Ingressos Pendentes',
                    color: '#ffbc00',
                    chart: 'line',
                    type: 'int'
                },
                canceled: {
                    url: 'canceled-tickets',
                    col: 'col-4',
                    icon: 'fas fa-ticket-alt',
                    name: 'Ingressos Cancelados',
                    color: '#fa5c7c',
                    chart: 'line',
                    type: 'int'
                }
            }
        }),
        methods: {
            changePage(page) {
                this.page = page
            }
        }
    }
</script>
