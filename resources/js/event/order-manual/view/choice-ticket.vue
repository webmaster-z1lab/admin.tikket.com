<template>
    <div class="tab-content b-0 mb-0">
        <div class="tab-pane show active my-3">
            <div class="table-responsive-sm">
                <table class="table table-striped table-centered mb-0">
                    <thead>
                    <tr>
                        <th>Ingresso</th>
                        <th>Disponibilidade</th>
                        <th>Data Final</th>
                        <th>Valor</th>
                        <th>Quant. de Ingressos</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="entrance in event.relationships.entrances">
                            <td>
                                {{entrance.attributes.name}}
                            </td>
                            <td>{{entrance.attributes.lot.available}}</td>
                            <td>{{formatDataTime(entrance.attributes.lot.finishes_at)}}</td>
                            <td>{{(entrance.attributes.lot.price / 100) | currency}}</td>
                            <td>
                                <select class="form-control" v-if="!entrance.attributes.lot.is_sold_out" @change="select" :class="validate ? 'is-invalid' : ''"
                                :data-id="entrance.id">
                                    <option selected value="0">0</option>
                                    <option :value="JSON.stringify({quant: index, entrance: entrance})" v-for="index in entrance.attributes.max_buy">
                                        {{index}}
                                    </option>
                                </select>

                                <span v-else>Ingressos Esgotados</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <ul class="list-inline wizard mb-0">
            <li class="previous list-inline-item" v-if="!checkItems">
                <button type="button" class="btn btn-warning" @click="canceledOrder">Cancelar</button>
            </li>
            <li class="next list-inline-item float-right">
                <button type="button" class="btn btn-primary" @click="nextOrder">Continuar</button>
            </li>
        </ul>
    </div>
</template>

<script>
    import swal from 'sweetalert2'
    import moment from 'moment'

    import {mapActions, mapState} from 'vuex'
    import {sendAlert} from "../../../vendor/common";

    export default {
        name: "choiceTicket",
        data: () => ({
            validate: false,
            items: []
        }),
        computed: {
            ...mapState({
                event: state => state.event
            }),
            checkItems(){
                return _.isEmpty(this.items)
            }
        },
        methods: {
            ...mapActions(['setItems']),
            async select(e) {
                let value = e.target.options[e.target.selectedIndex].value

                if (value === 0) {
                    this.removeItems(e.target.dataset.id)

                    return;
                } else {
                    value = JSON.parse(value)

                    await this.removeItems(e.target.dataset.id)

                    for(let i = 0; i < value.quant; i++) {
                        this.items.push({
                            lot: value.entrance.attributes.lot.number,
                            entrance: value.entrance.id,
                            entrance_name: value.entrance.attributes.name,
                            validate_user: '',
                            name: '',
                            email: '',
                            document: '',
                            price: value.entrance.attributes.lot.price
                        })
                    }
                }
            },
            formatDataTime(date){
                return moment(date, "YYYY-MM-DD[T]HH:mm:ss").format('DD/MM/YYYY HH:mm')
            },
            nextOrder() {
                this.validate = false

                if (this.checkItems) {
                    this.validate = true

                    sendAlert({
                        title: 'Dados Faltando',
                        message: 'Você precisa selecionar a quantidade de Ingressos de pelo menos um dos ingressos.',
                        type: 'error'
                    })

                    return;
                }

                this.setItems(this.items)

                this.$emit('changeKey', 'identification')
            },
            canceledOrder() {
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
                        sendAlert({
                            title: 'Tudo Certo!',
                            message: 'Pedido Cancelado.',
                            type: 'success'
                        })

                        let selections = document.getElementsByTagName('select')

                        for(let select of selections) {
                            select.selectedIndex = 0
                        }

                        this.items = []
                    }
                })

            },
            async removeItems(id) {
                _.remove(this.items, function(n) {
                    return n.entrance === id;
                });
            }
        }
    }
</script>
