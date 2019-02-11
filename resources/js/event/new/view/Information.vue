<template>
    <div class="col-8">
        <form class="needs-validation">
            <loading-component :is-loading="isLoading"></loading-component>

            <div class="row">
                <div class="form-group col-12">
                    <label class="col-form-label"> Nome do Evento <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" v-model="event.attributes.name"
                           :class="errors.has('name') ? 'is-invalid' : ''" v-validate="'required|max:100'"
                           data-vv-as="Nome do Evento"/>
                    <div v-show="errors.has('name')" class="invalid-feedback">
                        {{ errors.first('name') }}
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="col-form-label"> Breve Descrição do Evento <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="summary" v-model="event.attributes.description"
                              :class="errors.has('summary') ? 'is-invalid' : ''" v-validate="'required|max:250'"
                              data-vv-as="Breve Descrição do Evento"></textarea>
                    <div v-show="errors.has('summary')" class="invalid-feedback">
                        {{ errors.first('summary') }}
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="col-form-label"> Evento Privado?</label>
                    <div class="custom-control custom-checkbox form-custom" style="padding-left: 0">
                        <input type="checkbox" id="switch1" data-switch="bool" name="private" v-model="event.attributes.is_public">
                        <label for="switch1" data-on-label="Sim" data-off-label="Não"></label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label class="col-form-label"> Categoria <span class="text-danger">*</span></label>
                    <select class="form-control" name="category" :class="errors.has('category') ? 'is-invalid' : ''"
                            v-validate="'required'" data-vv-as="Categoria" v-model="event.attributes.category">
                        <option selected value="">Selecione uma Categoria</option>
                        <option v-for="category in categories">{{category.attributes.name}}</option>
                    </select>
                    <div v-show="errors.has('category')" class="invalid-feedback">
                        {{ errors.first('category') }}
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label class="col-form-label"> Data de Início <span class="text-danger">*</span></label>
                    <the-mask class="form-control" type="text" name="start_date" placeholder="##/##/#### ##:##"
                              :class="errors.has('start_date') ? 'is-invalid' : ''"
                              v-validate="'required|date_format:DD/MM/YYYY HH:mm|today'"
                              data-vv-as="Data de Início" :masked="true" :mask="'##/##/#### ##:##'"
                              v-model="event.attributes.starts_at">
                    </the-mask>
                    <div v-show="errors.has('start_date')" class="invalid-feedback">
                        {{ errors.first('start_date') }}
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label class="col-form-label"> Data de Término <span class="text-danger">*</span></label>
                    <the-mask class="form-control" type="text" name="end_date" placeholder="##/##/#### ##:##"
                              :class="errors.has('end_date') ? 'is-invalid' : ''"
                              v-validate="`required|date_format:DD/MM/YYYY HH:mm|date_after:${event.attributes.starts_at}`"
                              data-vv-as="Data de Término" :masked="true" :mask="'##/##/#### ##:##'"
                              v-model="event.attributes.finishes_at">
                    </the-mask>
                    <div v-show="errors.has('end_date')" class="invalid-feedback">
                        {{ errors.first('end_date') }}
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="col-form-label"> Descrição do Evento <span class="text-danger">*</span></label>
                    <div>
                        <vue-editor name="description" :class="errors.has('description') ? 'is-invalid' : ''"
                                    data-vv-as="Descrição do Evento" v-validate="'required'"
                                    v-model="event.attributes.body"></vue-editor>
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
</template>

<script>
    import LoadingComponent from '../../../components/loadingComponent'
    import swal from 'sweetalert2'
    import moment from 'moment'
    import LocalStorage from "../../../vendor/storage"

    import {TheMask} from 'vue-the-mask'
    import {VueEditor} from 'vue2-editor'
    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST, toSeek} from "../../../vendor/common"

    export default {
        name: "Information",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            LoadingComponent,
            TheMask,
            VueEditor
        },
        data: () => ({
            isLoading: false,
            categories: {}
        }),
        computed: {
            ...mapState({
                event: state => state.event,
                start_event: state => state.start_event
            })
        },
        methods: {
            ...mapActions(['changeEvent']),
            submit() {
                this.$validator.validateAll().then(
                    async res => {
                        if (res) {
                            Pace.start()
                            this.isLoading = true

                            let data = {
                                name: this.event.attributes.name,
                                description: this.event.attributes.description,
                                body: this.event.attributes.body,
                                category: this.event.attributes.category,
                                starts_at: moment(this.event.attributes.starts_at, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD HH:mm'),
                                finishes_at: moment(this.event.attributes.finishes_at, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD HH:mm'),
                                is_public: _.isBoolean(this.event.attributes.is_public) ? this.event.attributes.is_public : false,
                                _method: this.start_event ? 'POST' : 'PUT'
                            }

                            await sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/events${this.start_event ? '' : ('/' + this.event.id)}`, data).then(
                                async response => {
                                    if (this.start_event) new LocalStorage('event__').setItem('id', response.data.data.id)

                                    await this.changeEvent(response.data.data)

                                    this.$router.push({name: 'organizer'})
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
        },
        mounted() {
            toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/categories`).then(response => this.categories = response.data).catch(error => console.dir(error))
        }
    }
</script>
