<template>
    <div class="left-side-menu">
        <div class="slimscroll-menu">
            <a href="" class="logo text-center">
                <img :src="`${getEnvAWS}/images/tikket/ticket_gradient.png`" alt="" width="45px">
            </a>

            <ul class="metismenu side-nav">
                <li class="side-nav-title side-nav-item">Navegação</li>

                <li class="side-nav-item" v-for="(item, key, index) in menu">
                    <router-link :to="item.index" class="side-nav-link" aria-expanded="false" :class="classActive(key, index)">
                        <i :class="item.icon"></i>
                        <span> {{key}} </span>
                    </router-link>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'sideBarPartial',
        data: () => ({
            menu: {
                'Painel de Dados': {
                    icon: "fas fa-solar-panel",
                    routes: ['painel'],
                    index: 'painel'
                },
                'Participantes': {
                    icon: "fas fa-users",
                    routes: ['participantes'],
                    index: 'participantes'
                },
                'Ingressos': {
                    icon: "fas fa-ticket-alt",
                    routes: ['ingressos'],
                    index: 'ingressos'
                },
                'Check-In': {
                    icon: "fas fa-clipboard-check",
                    routes: ['check-in'],
                    index: 'check-in'
                },
                'Financeiro': {
                    icon: "fas fa-money-bill-wave",
                    routes: ['financeiro'],
                    index: 'financeiro'
                }
            }
        }),
        computed: {
            getEnvAWS() {
                return process.env.MIX_AWS_CDN_ENDPOINT
            }
        },
        methods: {
            classActive(name, key) {
                let active = collect(this.menu[name].routes).filter((value, key) => value === this.$route.name).all()

                if (!_.isEmpty(active)) {
                    return 'active'
                }
            }
        }
    }
</script>
