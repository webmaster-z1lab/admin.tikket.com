import Vue from 'vue'
import VueCurrencyFilter from 'vue-currency-filter'

/* Local Storage */
import LocalStorage from "../../vendor/storage"

/* Loading */
import LoadingComponent from '../../components/loadingComponent'

/* Money */
Vue.use(VueCurrencyFilter,
    {
        symbol : 'R$',
        thousandsSeparator: '.',
        fractionCount: 2,
        fractionSeparator: ',',
        symbolPosition: 'front',
        symbolSpacing: true
    })

import swal from 'sweetalert2'
import {sendAPIDELETE, exceptionError, sendAlert} from "../../vendor/common";

new Vue({
    el: '#vue-event-index',
    name: 'VueEventIndex',
    components: {
        LoadingComponent
    },
    data: () => ({
        isLoading: false
    }),
    methods: {
        createEvent() {
            new LocalStorage('event__').removeItem('id')

            window.location.href = route('event.create')
        },
        editEvent(event) {
            if(event.attributes.status === 'draft') {
                new LocalStorage('event__').setItem('id', event.id)

                window.location.href = route('event.create')
            } else {
                window.location.href = route('event.edit', event.id)
            }
        },
        deleteEvent(event) {
            if (event.attributes.status !== 'published') {
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
                        this.isLoading = true
                        Pace.start()

                        sendAPIDELETE(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${event.id}`, {})
                            .then(response => window.location.reload())
                            .catch((error) => exceptionError(error))
                            .finally(() => {
                                this.isLoading = false
                                Pace.stop()
                            })
                    }
                })
            } else {
                sendAlert({title: 'Evento Publicado', message: 'Desculpe, mais antes de excluir um evento ele precisar estar despublicado!', type: 'warning'})
            }
        }
    }
});
