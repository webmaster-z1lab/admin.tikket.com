<template>
    <div class="col-8">
        <form class="needs-validation">
            <div class="row">
                <div class="form-group col-12">
                    <label class="col-form-label"> Nome do Evento (máx. 100 caracteres) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" v-model="event.attributes.name"
                           placeholder="Ex: Festa da turma"
                           :class="errors.has('name') ? 'is-invalid' : ''" v-validate="'required|max:100'"
                           data-vv-as="Nome do Evento"/>
                    <div v-show="errors.has('name')" class="invalid-feedback">
                        {{ errors.first('name') }}
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="col-form-label"> Breve Descrição do Evento (máx. 250 caracteres) <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="summary" v-model="event.attributes.description"
                              placeholder="Ex: Melhor festa do ano, com o melhor som da cidade, bebida liberada e muita gente animada."
                              :class="errors.has('summary') ? 'is-invalid' : ''" v-validate="'required|max:250'"
                              data-vv-as="Breve Descrição do Evento"></textarea>
                    <div v-show="errors.has('summary')" class="invalid-feedback">
                        {{ errors.first('summary') }}
                    </div>
                </div>

                <div class="form-group col-12">
                    <label class="col-form-label"> Evento Público?</label>
                    <div class="custom-control custom-checkbox form-custom" style="padding-left: 0">
                        <input type="checkbox" id="switch1" data-switch="bool" name="public" v-model="event.attributes.is_public">
                        <label for="switch1" data-on-label="Sim" data-off-label="Não"></label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label class="col-form-label"> Categoria <span class="text-danger">*</span></label>
                    <select class="form-control" name="category" :class="errors.has('category') ? 'is-invalid' : ''"
                            v-validate="'required'" data-vv-as="Categoria" v-model="event.attributes.category">
                        <option selected value="">Selecione uma Categoria</option>
                        <option v-for="category in categories" :value="category.attributes.value">{{category.attributes.name}}</option>
                    </select>
                    <div v-show="errors.has('category')" class="invalid-feedback">
                        {{ errors.first('category') }}
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label class="col-form-label"> Data de Início <span class="text-danger">*</span></label>
                    <the-mask class="form-control" type="text" name="start_date" placeholder="DD/MM/AAAA HH:MM"
                              :class="errors.has('start_date') ? 'is-invalid' : ''"
                              v-validate="'required|date_format:dd/MM/yyyy HH:mm|today'"
                              data-vv-as="Data de Início" :masked="true" :mask="'##/##/#### ##:##'"
                              v-model="event.attributes.starts_at">
                    </the-mask>
                    <div v-show="errors.has('start_date')" class="invalid-feedback">
                        {{ errors.first('start_date') }}
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label class="col-form-label"> Data de Término <span class="text-danger">*</span></label>
                    <the-mask class="form-control" type="text" name="end_date" placeholder="DD/MM/AAAA HH:MM"
                              :class="errors.has('end_date') ? 'is-invalid' : ''"
                              v-validate="`required|date_format:dd/MM/yyyy HH:mm|date_after:${event.attributes.starts_at}`"
                              data-vv-as="Data de Término" :masked="true" :mask="'##/##/#### ##:##'"
                              v-model="event.attributes.finishes_at">
                    </the-mask>
                    <div v-show="errors.has('end_date')" class="invalid-feedback">
                        {{ errors.first('end_date') }}
                    </div>
                </div>

                <div class="form-group col-12">
                    <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading">Descrição do Evento</h4>

                        <p class="mb-0">
                            Utilize esse campo para fornecer informações detalhadas sobre o seu evento, como informações de transporte no dia do evento, regras de idade, cardápio,
                            carta de bebidas, mapa dos ambientes e tudo mais que considerar necessário para que os participantes tenham total conhecimento de tudo que a sua
                            organização está oferecendo.
                        </p>
                    </div>

                    <div>
                        <vue-editor name="description" :class="errors.has('description') ? 'is-invalid' : ''"
                                    data-vv-as="Descrição do Evento" v-validate="'required'"
                                    v-model="event.attributes.body"></vue-editor>
                    </div>
                    <div v-show="errors.has('description')" class="invalid-feedback">
                        {{ errors.first('description') }}
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="row">
                        <div class="col-md-6 align-self-center">
                            <div class="alert alert-primary" role="alert">
                                <h4 class="alert-heading">Capa do Evento</h4>

                                <p>A dimensão recomendada é de 1600 x 838 e os formatos aceitos são JPEG, WEBP, SVG ou PNG. O tamanho máximo do arquivo é de 2 mb.</p>
                                <hr>
                                <p class="mb-0">Imagens com dimensões diferentes da recomendada serão adaptadas. Os diversos formatos e dimensões utilizados pelo site serão gerados
                                    automaticamente pelo nosso sistema.</p>
                            </div>

                            <div class="text-right mt-3" v-if="attachment">
                                <button type="button" class="btn btn-primary btn-sm" @click="clickUpload">Trocar Imagem</button>
                                <button type="button" class="btn btn-danger btn-sm" @click="removeAttachment">Remover</button>
                            </div>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <div class="form-group" @dragover.prevent @drop="onDrop" v-if="!attachment">
                                <div class="dropzone dz-clickable" :class="errors.has(uploadFieldName) ? 'is-invalid' : ''" @click="clickUpload">
                                    <div class="dz-message needsclick">
                                        <i class="h1 text-muted dripicons-cloud-upload"></i>
                                        <h4>Clique Aqui ou Arraste para adicionar uma Imagem.</h4>
                                    </div>
                                </div>
                                <div v-show="errors.has(uploadFieldName)" class="invalid-feedback" style="display: block">
                                    {{ errors.first(uploadFieldName) }}
                                </div>
                            </div>
                            <div v-else>
                                <img :src="attachment.imageURL" alt="" class="img" width="100%"/>
                            </div>

                            <input type="file" :name="uploadFieldName" @change="onFileChange($event.target.name, $event.target.files)"
                                   style="display: none" data-vv-as="Imagem" v-validate="'required'" ref="files"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">Termos de uso do organizador</h4>
                <p>Ao continuar você concorda com os nossos <a :href="getSiteUrl('termos-de-uso-organizador')" target="_blank">Termos de uso do
                    organizador</a> e <a :href="getSiteUrl('privacidade-e-cookies')" target="_blank">política de privacidade e cookies</a> além de
                    aceitar receber nossos e-mails com notificações e atualizações relacionadas ao seu evento.</p>
            </div>

            <ul class="list-inline mb-2 mt-3 wizard">
                <li class="next list-inline-item float-right">
                    <button type="button" class="btn btn-primary" @click="submit">Salvar e Continuar</button>
                </li>
            </ul>
        </form>
    </div>
</template>

<style>
    .dropzone.is-invalid {
        border        : 2px dashed #DE6557;
        background    : #FFFFFF;
        border-radius : 6px;
        cursor        : pointer;
        min-height    : 150px;
        padding       : 20px;
    }
</style>

<script>
    import moment from 'moment'
    import LocalStorage from "../../../../vendor/storage"

    import {TheMask} from 'vue-the-mask'
    import {VueEditor} from 'vue2-editor'
    import {mapActions, mapState} from 'vuex'
    import {sendUploadAPIPOST, toSeek, exceptionError, sendAlert} from "../../../../vendor/common"

    export default {
        name: "information",
        inject: ['$validator'],
        components: {
            TheMask,
            VueEditor
        },
        data: () => ({
            categories: {},
            attachment: null,
            uploadFieldName: 'cover',
            maxSize: 2048
        }),
        computed: {
            ...mapState({
                event: state => state.event,
                start_event: state => state.start_event
            })
        },
        methods: {
            ...mapActions(['changeEvent']),
            onDrop: function (e) {
                e.stopPropagation();
                e.preventDefault();

                this.onFileChange(e.dataTransfer.name, e.dataTransfer.files);
            },
            clickUpload() {
                this.$refs.files.click()
            },
            onFileChange(fieldName, file) {
                const {maxSize} = this
                let imageFile = file[0]

                //check if user actually selected a file
                if (file.length > 0) {
                    let size = imageFile.size / maxSize / maxSize
                    if (!imageFile.type.match('image.*')) {
                        // check whether the upload is an image
                        $.NotificationApp.send("Ops, algo deu errado!", "Por favor, escolha um arquivo de imagem", 'top-right', 'rgba(0,0,0,0.2)', 'error');
                    } else if (size > 1) {
                        // check whether the size is greater than the size limit
                        $.NotificationApp.send("Ops, algo deu errado!", "Por favor, escolha um arquivo que seja menor que 2MB", 'top-right', 'rgba(0,0,0,0.2)', 'error');
                    } else {
                        let imageURL = URL.createObjectURL(imageFile)

                        this.attachment = {imageFile, imageURL}
                    }
                }
            },
            getSiteUrl(uri) {
                return `${process.env.MIX_MAIN_SITE}/${uri}`
            },
            removeAttachment() {
                this.attachment = null;
            },
            createImage(file) {
                let reader = new FileReader(),
                    me = this

                reader.onload = (e) => {
                    me.image = e.target.result
                }

                reader.readAsDataURL(file)

                return this.image
            },
            submit() {
                this.$validator.validateAll().then(
                    async res => {
                        if (res) {
                            this.$emit('loading', true)

                            const params = new FormData();

                            params.set('name', this.event.attributes.name)
                            params.set('description', this.event.attributes.description)
                            params.set('body', this.event.attributes.body)
                            params.set('category', this.event.attributes.category)
                            params.set('starts_at', moment(this.event.attributes.starts_at, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD HH:mm'))
                            params.set('finishes_at', moment(this.event.attributes.finishes_at, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD HH:mm'))
                            params.append('is_public', _.isBoolean(this.event.attributes.is_public) ? this.event.attributes.is_public : false)
                            params.append('cover', this.attachment.imageFile)
                            params.set('_method', this.start_event ? 'POST' : 'PUT')

                            await sendUploadAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/events${this.start_event ? '' : ('/' + this.event.id)}`, params)
                                .then(async response => {
                                    if (this.start_event) new LocalStorage('event__').setItem('id', response.data.data.id)

                                    await this.changeEvent(response.data.data)

                                    sendAlert({
                                        title: 'Tudo Certo!',
                                        message: 'Evento iniciado com sucesso.',
                                        type: 'success'
                                    })

                                    this.$emit('loading', false)
                                    this.$router.push({name: 'organizer'})
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
            window.addEventListener("dragover", function (e) {
                e = e || event;
                e.preventDefault();
            }, false);
            window.addEventListener("drop", function (e) {
                e = e || event;
                e.preventDefault();
            }, false);

            toSeek(`${process.env.MIX_API_VERSION_ENDPOINT}/categories`).then(response => this.categories = response.data).catch((error) => exceptionError(error))
        }
    }
</script>
