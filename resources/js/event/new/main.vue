<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <!--<a href="{{route('event.new')}}" class="btn btn-primary">Criar Evento</a>-->
                    </div>

                    <h4 class="page-title">Novo Evento</h4>
                </div>
            </div>
        </div>

        <div class="row">
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
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 33.3333%;"></div>
                                </div>

                                <div class="row justify-content-center">
                                    <router-view></router-view>
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
    import LoadingComponent from '../../components/loadingComponent'
    import LocalStorage from "../../vendor/storage"
    import swal from 'sweetalert2'

    import {mapActions, mapState} from 'vuex'
    import {toSeek} from "../../vendor/common";

    export default {
        name: 'VueMain',
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            LoadingComponent
        },
        data: () => ({
            isLoading: true,
            key_active: null,
            menu_form: {
                'Informações Base': {
                    icon: "fas fa-file-contract mr-1",
                    routes: ['information']
                },
                'Organizador': {
                    icon: "fas fa-user-cog mr-1",
                    routes: ['organizer']
                },
                'Localização': {
                    icon: "fas fa-map-marker-alt mr-1",
                    routes: ['location']
                },
                'Ingressos': {
                    icon: "fas fa-ticket-alt mr-1",
                    routes: ['tickets', 'tickets.ticket']
                }
            }
        }),
        methods: {
            classActive(name, key) {
                let active = collect(this.menu_form[name].routes).filter((value, key) => value === this.$route.name).all()

                if (!_.isEmpty(active)) {
                    this.key_active = key

                    return 'active'
                }

                return key < this.key_active ? 'confirm' : ''
            }
        },
    }
</script>
