<template>
    <div class="col-8">
        <form class="needs-validation">
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="col-form-label">Escolher Organizador <span class="text-danger">*</span></label>
                    <select class="form-control" name="organizer" v-model="select_organizer">
                        <option selected :value="null">Criar novo Organizador</option>
                        <option v-for="organizer in organizers" :value="organizer">{{organizer.attributes.name}}</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <label class="col-form-label"> Nome <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" v-model="name"
                           :class="errors.has('name') ? 'is-invalid' : ''" v-validate="'required|max:60'"
                           data-vv-as="Nome"/>
                    <div v-show="errors.has('name')" class="invalid-feedback">
                        {{ errors.first('name') }}
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="col-form-label"> Descrição <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="description" v-model="description"
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
    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST, toSeek, exceptionError, sendAlert} from "../../../vendor/common"

    export default {
        name: "Organizer",
        $_veeValidate: {
            validator: 'new'
        },
        watch: {
            select_organizer(value) {
                if (value !== null) {
                    this.name = value.attributes.name
                    this.description = value.attributes.description
                } else {
                    this.name = ''
                    this.description = ''
                }
            },
            event(value) {
                this.select_organizer = value.relationships.producer
            }
        },
        data: () => ({
            organizers: [],
            name: '',
            description: '',
            select_organizer: null
        }),
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        methods: {
            ...mapActions(['changeEvent']),
            submit() {
                this.$validator.validateAll().then(
                    async res => {
                        if (res) {
                            this.$emit('loading', true)

                            let data = {
                                name: this.name,
                                description: this.description,
                                _method: 'POST'
                            }

                            await sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/producers`, data)
                                .then(async response => {
                                    await this.changeEvent(response.data.data)

                                    sendAlert({
                                        title: 'Tudo Certo!',
                                        message: 'Organizador vinculado com sucesso ao evento.',
                                        type: 'success'
                                    })

                                    this.$emit('loading', false)
                                    this.$router.push({name: 'location'})
                                })
                                .catch((error) => {
                                    this.$emit('loading', false)
                                    exceptionError(error)
                                })
                        }
                    }
                )
            }
        },
        mounted() {
            if (_.has(this.event, 'relationships.producer.attributes.user_id')) this.select_organizer = this.event.relationships.producer

            toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/producers`)
                .then(response => !_.isEmpty(response.data) ? this.organizers = response.data : '').catch((error) => exceptionError(error))
        }
    }
</script>
