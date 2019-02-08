<template>
    <transition name="component-fade" mode="out-in">
        <div class="col-8">
            <form class="needs-validation">
                <loading-component :is-loading="isLoading"></loading-component>

                <div class="row">
                    <div class="form-group col-12">
                        <label class="col-form-label"> Nome do Ingresso <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" v-model="event.name"
                               :class="errors.has('name') ? 'is-invalid' : ''" v-validate="'required|max:100'"
                               data-vv-as="Nome do Evento"/>
                        <div v-show="errors.has('name')" class="invalid-feedback">
                            {{ errors.first('name') }}
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label class="col-form-label"> Breve Descrição do Evento <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" name="summary" v-model="event.summary"
                                  :class="errors.has('summary') ? 'is-invalid' : ''" v-validate="'required|max:250'"
                                  data-vv-as="Breve Descrição do Evento"></textarea>
                        <div v-show="errors.has('summary')" class="invalid-feedback">
                            {{ errors.first('summary') }}
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label class="col-form-label"> Evento Privado?</label>
                        <div class="custom-control custom-checkbox form-custom" style="padding-left: 0">
                            <input type="checkbox" id="switch1" data-switch="bool" name="private"
                                   v-model="event.private">
                            <label for="switch1" data-on-label="Sim" data-off-label="Não"></label>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-form-label"> Data de Início <span class="text-danger">*</span></label>
                        <the-mask class="form-control" type="text" name="start_date" placeholder="##/##/#### ##:##"
                                  :class="errors.has('start_date') ? 'is-invalid' : ''"
                                  v-validate="'required|date_format:DD/MM/YYYY HH:mm'"
                                  data-vv-as="Data de Início" :masked="true" :mask="'##/##/#### ##:##'"
                                  v-model="event.start_date">
                        </the-mask>
                        <div v-show="errors.has('start_date')" class="invalid-feedback">
                            {{ errors.first('start_date') }}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-form-label"> Data de Término <span class="text-danger">*</span></label>
                        <the-mask class="form-control" type="text" name="end_date" placeholder="##/##/#### ##:##"
                                  :class="errors.has('end_date') ? 'is-invalid' : ''"
                                  v-validate="'required|date_format:DD/MM/YYYY H:m'"
                                  data-vv-as="Data de Início" :masked="true" :mask="'##/##/#### ##:##'"
                                  v-model="event.end_date">
                        </the-mask>
                        <div v-show="errors.has('end_date')" class="invalid-feedback">
                            {{ errors.first('end_date') }}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-form-label"> Categoria Principal <span class="text-danger">*</span></label>
                        <select class="form-control" name="category" :class="errors.has('category') ? 'is-invalid' : ''"
                                v-validate="'required'" data-vv-as="Categoria principal" v-model="event.category">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                        <div v-show="errors.has('category')" class="invalid-feedback">
                            {{ errors.first('category') }}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-form-label"> Categoria Secundária </label>
                        <select class="form-control" name="secondary_category" v-model="event.secondary_category">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>

                    <div class="form-group col-12">
                        <label class="col-form-label"> Descrição do Evento </label>
                        <div>
                            <vue-editor name="description" :class="errors.has('description') ? 'is-invalid' : ''"
                                        data-vv-as="Descrição do Evento" v-validate="'required'"
                                        v-model="event.description"></vue-editor>
                        </div>
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
    </transition>
</template>

<style>
    .component-fade-enter-active, .component-fade-leave-active {
        transition: opacity .3s ease;
    }
    .component-fade-enter, .component-fade-leave-to
        /* .component-fade-leave-active em versões anteriores a 2.1.8 */ {
        opacity: 0;
    }
</style>

<script>
    import LoadingComponent from '../../../components/loadingComponent'
    import swal from 'sweetalert2'

    import {TheMask} from 'vue-the-mask'
    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST} from "../../../vendor/common"
    import {VueEditor} from 'vue2-editor'

    export default {
        name: "NewTicket",
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
