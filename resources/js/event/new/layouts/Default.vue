<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="/" class="btn btn-warning btn-sm">Voltar a Home</a>
                        <a href="/" class="btn btn-danger btn-sm">Apagar Rascunho</a>
                    </div>

                    <h4 class="page-title">Novo Evento</h4>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Criando Evento</h4>
                        <div id="progressbarwizard">
                            <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                <li class="nav-item" v-for="(item, key, index) in menu_form">
                                    <router-link :to="{name: item.routes[0]}" class="nav-link rounded-0 pt-2 pb-2" :class="classActive(key, index)">
                                        <i :class="item.icon"></i>
                                        <span class="d-none d-sm-inline">{{key}}</span>
                                    </router-link>
                                </li>
                            </ul>

                            <div class="tab-content b-0 mb-0">

                                <div id="bar" class="progress mb-3" style="height: 7px;">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success" :style="`width: ${progress_bar}%`"></div>
                                </div>

                                <div class="row justify-content-center">
                                    <slot />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .nav-link.confirm {
        color: #fff !important;
        background-color: #0dd098 !important;
    }
</style>

<script>
    export default {
        name: 'LayoutDefault',
        data: () => ({
            key_active: null,
            progress_bar: 25,
            menu_form: {
                'Informações Base': {
                    icon: "fas fa-file-contract mr-1",
                    routes: ['information'],
                    progress: 25
                },
                'Organizador': {
                    icon: "fas fa-user-cog mr-1",
                    routes: ['organizer'],
                    progress: 50
                },
                'Localização': {
                    icon: "fas fa-map-marker-alt mr-1",
                    routes: ['location'],
                    progress: 75
                },
                'Ingressos': {
                    icon: "fas fa-ticket-alt mr-1",
                    routes: ['tickets', 'tickets.ticket'],
                    progress: 100
                }
            }
        }),
        methods: {
            classActive(name, key) {
                let active = collect(this.menu_form[name].routes).filter((value, key) => value === this.$route.name).all()

                if (!_.isEmpty(active)) {
                    this.key_active = key
                    this.progress_bar = this.menu_form[name].progress

                    return 'active'
                }

                return key < this.key_active ? 'confirm' : ''
            }
        }
    }
</script>
