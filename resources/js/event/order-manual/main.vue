<template>
    <div class="col-12 mt-4">
        <loading-component :is-loading="isLoading"></loading-component>
        <div class="card">
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
    </div>
</template>

<script>
    import LoadingComponent from '../../components/loadingComponent'
    import ChoiceTicket from './view/choice-ticket'
    import Identification from './view/identification'
    import Conclusion from './view/conclusion'

    import {mapActions, mapState} from 'vuex'

    export default {
        name: "manualInscription",
        $_veeValidate: {
            validator: 'new'
        },
        props: {
            data: {
                required: true,
                type: String
            }
        },
        computed: {
            ...mapState({
                isLoading: state => state.isLoading
            })
        },
        components: {
            LoadingComponent,
            ChoiceTicket,
            Identification,
            Conclusion
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
        created() {
            if (_.isString(this.data)) this.initEvent(this.data)
        },
        methods: {
            ...mapActions(['initEvent']),
            changeKey(key) {
                this.key_active = key
            }
        }
    }
</script>
