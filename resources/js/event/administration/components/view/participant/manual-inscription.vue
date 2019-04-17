<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header />

            <div class="col-12">
                <div class="card" v-if="event.attributes.status === 'published'">
                    <div class="card-body">
                        <h4 class="header-title mb-3"> Pedido Manual</h4>
                        <form>
                            <div id="basicwizard">
                                <ul class="nav nav-pills nav-justified form-wizard-header mb-4">
                                    <li class="nav-item" v-for="index in menu_form_wizard">
                                        <a href="javascript:;" class="nav-link rounded-0 pt-2 pb-2 show" :class="key_active === index.key ? 'active' : ''">
                                            <i :class="index.icon"></i>
                                            <span class="d-none d-sm-inline">{{index.name}}</span>
                                        </a>
                                    </li>
                                </ul>

                                <component :is="key_active" @changeKey="changeKey"/>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-2" v-else>
                    <figure class="mx-auto mb-4">
                        <img :src="'images/undraw/undraw_voice_control_ofo1.svg' | aws_url" alt="SVG" width="30%">
                    </figure>

                    <div class="mb-4">
                        <h1 class="h3"><strong>Evento Aguardando publicação!</strong></h1>

                        <p class="h5">Desculpe, mais antes de poder criar pedidos você deve publicar seu evento.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import ChoiceTicket from './partials/choice-ticket'
    import Identification from './partials/identification'
    import Conclusion from './partials/conclusion'

    import {mapState} from 'vuex'

    export default {
        name: "manualInscription",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            SubHeader,
            ChoiceTicket,
            Identification,
            Conclusion
        },
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        data: () => ({
            key_active: 'choice-ticket',
            menu_form_wizard: [{
                key: 'choice-ticket',
                name: 'Escolha de Ingressos',
                icon: "fas fa-ticket-alt mr-1"
            }, {
                key: 'identification',
                name: 'Identificação',
                icon: "far fa-id-card mr-1"
            }, {
                key: 'conclusion',
                name: 'Conclusão',
                icon: "mdi mdi-checkbox-marked-circle-outline mr-1"
            }]
        }),
        methods: {
            changeKey(key) {
                this.key_active = key
            }
        }
    }
</script>
