<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="/evento/meus-eventos" class="btn btn-warning btn-sm">Retornar</a>
                        <button type="button" class="btn btn-danger btn-sm" @click="deleteEvent" v-if="event.id">Apagar Rascunho</button>
                    </div>

                    <h4 class="page-title">Novo Evento</h4>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Criando Evento</h4>
                        <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert" v-show="event.id">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Obs - </strong>
                            Utilize a barra de navegação abaixo para facilitar sua locomoção entre as páginas de preenchimento do seu evento.
                        </div>
                        <div id="progressbarwizard">
                            <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                <li class="nav-item" v-for="(item, key, index) in menu_form">
                                    <a @click="checkCallRoute(item.to)" class="nav-link rounded-0 pt-2 pb-2" :class="classActive(key, index)" href="javascript:;">
                                        <i :class="item.icon"></i>
                                        <span class="d-none d-sm-inline">{{key}}</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content b-0 mb-0">
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
    import swal from 'sweetalert2'
    import LocalStorage from "../../../../vendor/storage"

    import {mapState} from 'vuex'
    import {sendAPIDELETE, exceptionError, sendAlert} from "../../../../vendor/common"

    export default {
        name: 'LayoutDefault',
        data: () => ({
            key_active: null,
            menu_form: {
                'Info. Base': {
                    icon: "fas fa-file-contract mr-1",
                    routes: ['information'],
                    to: 'information'
                },
                'Organizador': {
                    icon: "fas fa-user-cog mr-1",
                    routes: ['organizer'],
                    to: 'organizer'
                },
                'Localização': {
                    icon: "fas fa-map-marker-alt mr-1",
                    routes: ['location'],
                    to: 'location'
                },
                'Ingressos': {
                    icon: "fas fa-ticket-alt mr-1",
                    routes: ['tickets', 'tickets.ticket'],
                    to: 'tickets'
                }
            }
        }),
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        methods: {
            checkCallRoute(route) {
                if (this.event.id) {
                    this.$router.push({name: route})

                    return;
                }

                sendAlert({
                    title: "Ops, você não pode fazer isso!",
                    message: 'Antes de poder navegar entre as abas você deve salvar as info. Base para iniciar seu evento.',
                    type: 'warning',
                    time: 5000
                })
            },
            classActive(name, key) {
                let active = collect(this.menu_form[name].routes).filter((value, key) => value === this.$route.name).all()

                if (!_.isEmpty(active)) {
                    this.key_active = key
                    return 'active'
                }

                return key < this.key_active ? 'confirm' : ''
            },
            deleteEvent() {
                swal({
                    title: 'Você tem certeza?',
                    text: "Ao fazer isso você perderá todo o progresso de cadastro!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, apagar!'
                }).then((result) => {
                    if (result.value) {
                        this.$emit('loading', true)

                        sendAPIDELETE(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}`, {})
                            .then(response => {
                                new LocalStorage('event__').removeItem('id')

                                window.location.href = route('home')
                            })
                            .catch((error) => exceptionError(error))
                            .finally(() => this.$emit('loading', false))
                    }
                })
            }
        }
    }
</script>
