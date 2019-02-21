<template>
    <div class="left-side-menu">
        <div class="slimscroll-menu">
            <a href="" class="logo text-center">
                <img :src="`${getEnvAWS}/images/tikket/ticket_gradient.png`" alt="" width="45px">
            </a>

            <ul class="metismenu side-nav">
                <li class="side-nav-title side-nav-item">Navegação</li>

                <li class="side-nav-item" v-for="(item, key, index) in menu">
                    <a href="javascript: void(0);" class="side-nav-link" @click="pushIndex(item.index)">
                        <i :class="item.icon"></i>
                        <span> {{key}} </span>
                        <span class="menu-arrow" v-if="item.sub_menu"></span>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false" v-if="item.sub_menu">
                        <router-link tag="li" :to="{name: sub_route.to}" v-for="(sub_route, key) in item.sub_routes" :key="sub_route.name + key">
                            <a>{{sub_route.name}}</a>
                        </router-link>
                    </ul>
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
                    routes: ['panel', 'edit-event'],
                    index: 'panel'
                },
                'Ingressos': {
                    icon: "fas fa-ticket-alt",
                    routes: ['ticket', 'ticket.coupon'],
                    index: 'ticket',
                    sub_menu: true,
                    sub_routes: [
                        {name: 'Ingressos', to: 'ticket'},
                        {name: 'Cupons de Desconto', to: 'ticket.coupon'}
                    ]
                },
                'Participantes': {
                    icon: "fas fa-users",
                    routes: ['participant', 'participant.manual-inscription'],
                    index: 'participant',
                    sub_menu: true,
                    sub_routes: [
                        {name: 'Participantes', to: 'participant'},
                        {name: 'Inscrição Manual', to: 'participant.manual-inscription'}
                    ]
                },
                'Check-In': {
                    icon: "fas fa-clipboard-check",
                    routes: ['check-in'],
                    index: 'check-in'
                },
                'Financeiro': {
                    icon: "fas fa-money-bill-wave",
                    routes: ['financial'],
                    index: 'financial'
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
            },
            pushIndex(value){
                this.$router.push({name: value})
            }
        }
    }
</script>
