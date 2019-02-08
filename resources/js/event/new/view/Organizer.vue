<template>
    <div class="col-8">
        <form class="needs-validation">
            <loading-component :is-loading="isLoading"></loading-component>

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="col-form-label"> Organizador <span class="text-danger">*</span></label>
                    <select class="form-control" name="organizer" :class="errors.has('organizer') ? 'is-invalid' : ''"
                            v-validate="'required'" data-vv-as="Organizador"
                            v-model="event.organizer">
                        <option selected value="">Criar novo Organizador</option>
                    </select>

                    <div v-show="errors.has('organizer')" class="invalid-feedback">
                        {{ errors.first('organizer') }}
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="col-form-label"> Nome <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" v-model="event.organizer_name"
                           :class="errors.has('name') ? 'is-invalid' : ''" v-validate="'required|max:60'"
                           data-vv-as="Nome"/>
                    <div v-show="errors.has('name')" class="invalid-feedback">
                        {{ errors.first('name') }}
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="col-form-label"> Descrição <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="description" v-model="event.organizer_description"
                              :class="errors.has('description') ? 'is-invalid' : ''" v-validate="'required|max:500'"
                              data-vv-as="Descrição"></textarea>
                    <div v-show="errors.has('description')" class="invalid-feedback">
                        {{ errors.first('description') }}
                    </div>
                </div>
            </div>


            <ul class="list-inline mb-2 mt-3 wizard">
                <li class="next list-inline-item float-right">
                    <button type="button" class="btn btn-primary" @click="submit">Salvar e Continuar</button>
                </li>
            </ul>
        </form>
    </div>
</template>

<script>
    import LoadingComponent from '../../../components/loadingComponent'
    import swal from 'sweetalert2'

    import {TheMask} from 'vue-the-mask'
    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST} from "../../../vendor/common"
    import {VueEditor} from 'vue2-editor'

    export default {
        name: "Organizer",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            LoadingComponent,
            TheMask,
            VueEditor
        },
        data: () => ({
            isLoading: false
        }),
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        methods: {
            ...mapActions(['changeCart']),
            submit() {
                this.$validator.validateAll().then(
                    async res => {
                        if (res) {
                            Pace.start()
                            this.isLoading = true

                            let data = {
                                callback: "payment",
                                tickets: this.cart.attributes.tickets,
                                _method: 'PATCH'
                            }

                            await sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/carts/${this.cart.id}/tickets`, data).then(
                                async response => {
                                    await this.changeCart(response.data.data)
                                    this.$router.push({name: 'payment'})
                                }
                            ).catch(
                                (error) => {
                                    if (_.isObject(error.response)) {
                                        swal({
                                            type: 'error',
                                            title: 'Ops, algo deu errado!',
                                            text: error.response.data.errors.detail
                                        })
                                    } else {
                                        console.dir(error)
                                    }
                                }
                            ).finally(
                                () => {
                                    Pace.stop()
                                    this.isLoading = false
                                }
                            )
                        }
                    }
                )
            }
        }
    }
</script>
