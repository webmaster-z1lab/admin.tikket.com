<template>
    <div class="col-12">
        <div class="row">
            <div class="col-md-6">
                <div v-if="!newLocation && !change_address">
                    <div class="page-title-right">
                        <button type="button" class="btn btn-outline-primary" @click="change_address = true">Trocar Endereço</button>
                    </div>

                    <div class="card cta-box bg-info text-white mt-3">
                        <div class="card-body">
                            <div class="media-body">
                                <h4 class="mt-1 mb-1">Endereço Cadastrado</h4>
                                <p class="font-13"> Local: {{event.attributes.address.name}}</p>

                                <ul class="mb-0 list-inline">
                                    <li class="list-inline-item mr-3">
                                        <h5 class="mb-1">Endereço: {{event.attributes.address.formatted}}</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <ul class="list-inline mb-2 mt-3 wizard">
                        <li class="next list-inline-item float-right">
                            <router-link :to="{name: 'tickets'}" class="btn btn-primary" >Continuar</router-link>
                        </li>
                    </ul>
                </div>

                <div v-else>
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-warning" @click="change_address = false" v-if="!newLocation">Cancelar</button>
                        </div>
                    </div>


                    <div>
                        <div class="form-group">
                            <label class="col-form-label"> Endereço ou Nome do Local do Evento <span class="text-danger">*</span></label>
                            <gmap-autocomplete @place_changed="setPlace" class="form-control"></gmap-autocomplete>
                        </div>

                        <div class="row" v-if="place">
                            <div class="form-group col-md-8">
                                <label class="col-form-label">
                                    Nome do Local <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" name="place_name" placeholder="Nome do Bairro"
                                       :class="errors.has('place_name') ? 'is-invalid' : ''" v-model="place_name" data-vv-as="'Nome do Local'" v-validate="'required'">
                                <div v-show="errors.has('place_name')" class="invalid-feedback">
                                    {{ errors.first('place_name') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label">
                                    CEP <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control disabled" readonly disabled name="cep" :value="cep">
                            </div>

                            <div class="col-md-12">
                                <label class="col-form-label">
                                    Logradouro <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" name="street" placeholder="Nome da rua"
                                       :class="errors.has('street') ? 'is-invalid' : ''" v-model="street" data-vv-as="'Logradouro'" v-validate="'required'">
                                <div v-show="errors.has('street')" class="invalid-feedback">
                                    {{ errors.first('street') }}
                                </div>
                            </div>

                            <div class="form-group col-md-5">
                                <label class="col-form-label">
                                    Bairro <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" name="district" placeholder="Nome do Bairro"
                                       :class="errors.has('district') ? 'is-invalid' : ''" v-model="district" data-vv-as="'Bairro'" v-validate="'required'">
                                <div v-show="errors.has('district')" class="invalid-feedback">
                                    {{ errors.first('district') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label">
                                    Complemento
                                </label>
                                <input class="form-control" type="text" name="complement" placeholder="Ex: Casa, Loja 01..." v-model="complement">
                                <div v-show="errors.has('complement')" class="invalid-feedback">
                                    {{ errors.first('complement') }}
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="col-form-label">
                                    Número <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="number" name="number" placeholder="Ex: 55"
                                       :class="errors.has('number') ? 'is-invalid' : ''" v-model="number" data-vv-as="'Número'" v-validate="'required'">
                                <div v-show="errors.has('number')" class="invalid-feedback" style="display: block">
                                    {{ errors.first('number') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="col-form-label">
                                    Estado <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control disabled" readonly disabled name="state" :value="state">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="col-form-label">
                                    Cidade <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control disabled" readonly disabled name="city" :value="city">
                            </div>

                            <div class="col-12">
                                <ul class="list-inline mb-2 mt-3 wizard">
                                    <li class="next list-inline-item float-right">
                                        <button type="button" class="btn btn-primary" @click="submit">Salvar e Continuar</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 right">
                <gmap-map :center="center" :zoom="zoom" style="width:80%;  height: 300px; margin-left:20%;">
                    <gmap-marker :position="marker.position" @click="center=marker.position"></gmap-marker>
                </gmap-map>
            </div>
        </div>
    </div>
</template>

<script>
    import {TheMask} from 'vue-the-mask'
    import {mapActions, mapState} from 'vuex'
    import {sendAPIPOST, exceptionError, sendAlert} from "../../../vendor/common"
    import {VueEditor} from 'vue2-editor'

    export default {
        name: "Location",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            TheMask,
            VueEditor
        },
        data: () => ({
            //form
            street: '',
            cep: '',
            number: '',
            district: '',
            complement: '',
            formatted: '',
            state: '',
            city: '',
            place_name: '',
            lat: '',
            lng: '',
            maps_url: '',
            //map
            center: {lat: -20.7287352, lng: -42.8650568},
            zoom: 12,
            marker: {},
            place: null,
            //configs
            change_address: false
        }),
        computed: {
            ...mapState({
                event: state => state.event
            }),
            newLocation(){
                const isAddress = _.has(this.event, 'attributes.address.name')

                if (isAddress) {
                    this.center.lat = this.event.attributes.address.coordinate.location.lat
                    this.center.lng = this.event.attributes.address.coordinate.location.lng

                    this.marker = {
                        position: {
                            lat: this.event.attributes.address.coordinate.location.lat,
                            lng: this.event.attributes.address.coordinate.location.lng
                        }
                    }

                    this.zoom = 18
                }

                return !isAddress
            }
        },
        methods: {
            ...mapActions(['changeEvent']),
            setPlace(place) {
                this.$emit('loading', true)

                if (place) {
                    const marker = {
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng()
                    };

                    //configs
                    this.marker = {position: marker};
                    this.place = place;
                    this.center = marker;

                    //fill fields
                    this.place_name = place.name
                    this.lat = marker.lat
                    this.lng = marker.lng
                    this.maps_url = place.url
                    this.street = this.getGoogleApi(place.address_components, 'route').long_name
                    this.cep = this.getGoogleApi(place.address_components, 'postal_code').long_name
                    this.number = this.getGoogleApi(place.address_components, 'street_number').long_name
                    this.complement = this.getGoogleApi(place.address_components, 'subpremise').long_name
                    this.district = this.getGoogleApi(place.address_components, 'sublocality_level_1').long_name
                    this.state = this.getGoogleApi(place.address_components, 'administrative_area_level_1').short_name
                    this.city = this.getGoogleApi(place.address_components, 'administrative_area_level_2').long_name
                    this.formatted = place.formatted_address
                }

                this.$emit('loading', false)
            },
            geolocate: function () {
                navigator.geolocation.getCurrentPosition(position => {
                    this.center = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                });
            },
            getGoogleApi(arr ,parameter){
                let array = _.filter(arr, function(o) {
                    let collection = collect(o.types)
                    return collection.search(parameter) !== false
                })

                if (_.isEmpty(array)) return {long_name: '', short_name: ''}

                return array[0]
            },
            submit() {
                this.$validator.validateAll().then(
                    async res => {
                        if (res) {
                            this.$emit('loading', true)

                            let data = {
                                name:        this.place_name,
                                street:      this.street,
                                number:      this.number,
                                district:    this.district,
                                complement:  this.complement,
                                city:        this.city,
                                state:       this.state,
                                postal_code: this.cep.replace('-', ''),
                                formatted:   this.formatted,
                                maps_url:    this.maps_url,
                                coordinate:  {lat: this.lat, lng: this.lng},
                                _method: 'PATCH'
                            }

                            await sendAPIPOST(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/address`, data)
                                .then(async response => {
                                    await this.changeEvent(response.data.data)
                                    sendAlert({
                                        title: 'Tudo Certo!',
                                        message: 'Local adicionado ao evento com sucesso.',
                                        type: 'success'
                                    })

                                    this.$emit('loading', false)
                                    this.$router.push({name: 'tickets'})
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
            this.geolocate();
        }
    }
</script>
