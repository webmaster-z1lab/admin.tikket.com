<template>
    <transition name="slide-fade">
        <div class="card-body">
            <h4 class="header-title">Cadastro de Nível de Acesso</h4>

            <form class="needs-validation mt-2">
                <div class="row mt-3">
                    <div class="form-group col-md-12">
                        <label class="col-form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" v-model="email"
                               placeholder="Email para cadastro do nível de acesso"
                               :class="errors.has('email') ? 'is-invalid' : ''" v-validate="'required|email'" data-vv-as="Email"/>
                        <div v-show="errors.has('email')" class="invalid-feedback">
                            {{ errors.first('email') }}
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <h4 class="header-title mt-5 mt-sm-0">Selecione o Nível de Acesso</h4>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-6"  v-for="(index, key) in permissions">
                                    <div class="card border-0 mb-1">
                                        <div class="card-body p-3">
                                            <div class="custom-control custom-radio d-flex align-items-center small text-muted">
                                                <input type="radio" class="custom-control-input" :id="index.value" name="permission"
                                                       v-model="permission"
                                                       :value="index.value"
                                                       :class="errors.has('permission') ? 'is-invalid' : ''" v-if="!key">
                                                <input type="radio" class="custom-control-input" :id="index.value" name="permission"
                                                       v-model="permission"
                                                       v-validate="'required'"
                                                       data-vv-as="Nível de Acesso"
                                                       :value="index.value"
                                                       :class="errors.has('permission') ? 'is-invalid' : ''" v-else>
                                                <label class="custom-control-label ml-1" :for="index.value">
                                                    <strong class="h5 text-dark">{{index.name}}</strong>
                                                    <span class="d-block">{{index.description}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="list-inline mb-2 mt-3 wizard">
                    <li class="next list-inline-item float-right">
                        <button type="button" class="btn btn-warning" @click="$emit('changePage', 'accesses')">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="submit">Criar Acesso</button>
                    </li>
                </ul>
            </form>
        </div>
    </transition>
</template>

<style>
    /* Animações de entrada e saída podem utilizar diferentes  */
    /* funções de duração e de tempo.                          */
    .slide-fade-enter-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-leave-active {
        transition: all .0s ease;
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active em versões anteriores a 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }
</style>

<script>
    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST, exceptionError, sendAlert, toSeek} from "../../../../../../vendor/common"

    export default {
        name: "newAccess",
        inject: ['$validator'],
        data: () => ({
            email: '',
            permission: '',
            permissions: {}
        }),
        computed: {
            ...mapState({
                event: state => state.event,
            })
        },
        created(){
            toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/my-permissions`)
                .then(response => {
                    this.permissions = response
                })
                .catch((error) => exceptionError(error))
        },
        methods: {
            ...mapActions(['setAccesses', 'changeLoading']),
            submit() {
                this.$validator.validateAll().then(
                    async res => {
                        if (res) {
                            this.changeLoading(true)

                            let data = {
                                type: this.permission,
                                email: this.email,
                                _method: 'POST'
                            }

                            await sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/permissions`, data)
                                .then(async response => {
                                    await this.setAccesses(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/permissions`)

                                    sendAlert({
                                        title: 'Tudo Certo!',
                                        message: 'Nível de acesso criado com sucesso.',
                                        type: 'success'
                                    })

                                    this.$emit('changePage', 'accesses')
                                })
                                .catch((error) => {
                                    this.changeLoading(false)
                                    exceptionError(error)
                                })
                        }
                    }
                )
            }
        }
    }
</script>
