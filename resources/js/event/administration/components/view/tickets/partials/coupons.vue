<template>
    <div class="card-body">
        <div class="card-widgets">
            <button type="button" class="btn btn-icon btn-primary btn-sm" @click="coupon(true)">
                <i class="fas fa-plus"></i> Criar Cupom
            </button>
        </div>
        <h4 class="card-title mb-0">Cupons de Desconto</h4>

        <div class="table-responsive-sm mt-3">
            <table class="table table-striped table-centered mb-0">
                <thead>
                <tr>
                    <th>Tag</th>
                    <th>Código</th>
                    <th>Desconto</th>
                    <th>Ref. Ingresso</th>
                    <th>Utilizações</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="index in coupons">
                    <td>{{index.attributes.name}}</td>
                    <td>{{index.attributes.code}}</td>
                    <td v-if="index.attributes.is_percentage">
                        {{index.attributes.discount}} %
                    </td>
                    <td v-else>
                        {{(index.attributes.discount / 100) | currency}}
                    </td>
                    <td>{{index.relationships.entrance.attributes.name}}</td>
                    <td>{{index.attributes.used}}</td>
                    <td class="table-action text-center">
                        <a href="javascript:;" class="action-icon" @click="coupon(false, index)">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                        <a href="javascript:;" class="action-icon" @click="deleteCoupon(index)" v-if="!index.attributes.is_locked">
                            <i class="mdi mdi-delete"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="text-center mt-2" v-if="checkCoupons">
                <figure class="mx-auto mb-4">
                    <img :src="'images/undraw/undraw_printing_invoices_5r4r.svg' | aws_url" alt="SVG"
                         width="20%">
                </figure>

                <div class="mb-4">
                    <h1 class="h3"><strong>Nenhum Cupom foi encontrado</strong></h1>

                    <p class="h5">Caso tenha o desejo de criar cupons de desconto clique no botão abaixo!</p>

                    <button type="button" @click="coupon(true)" class="btn btn-icon btn-primary">
                        Adicionar Cupom
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert2'

    import {mapActions, mapState} from 'vuex'
    import {sendAPIDELETE, exceptionError, sendAlert} from "../../../../../../vendor/common"

    export default {
        name: "coupons",
        computed: {
            ...mapState({
                event: state => state.event,
                coupons: state => state.tickets.coupons
            }),
            checkCoupons() {
                return _.isEmpty(this.coupons)
            }
        },
        created(){
              this.setCoupons(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/coupons`)
        },
        methods: {
            ...mapActions(['setCoupon', 'setCoupons', 'changeLoading']),
            coupon(new_ticket, coupon) {
                if (new_ticket) {
                    this.setCoupon({
                        id: null,
                        is_locked: false,
                        entrance_id: '',
                        tag: '',
                        is_percentage: false,
                        validate_at: '',
                        code: _.toUpper(this.bin2hex(this.random_bytes(5))),
                        discount: 0,
                        reuse: 1
                    })

                    this.$emit('changePage', 'new-edit-coupon')
                } else {
                    this.setCoupon({
                        id: coupon.id,
                        is_locked: coupon.attributes.is_locked,
                        entrance_id: coupon.relationships.entrance.id,
                        tag: coupon.attributes.name,
                        is_percentage: coupon.attributes.is_percentage,
                        validate_at: coupon.attributes.valid_until,
                        code: coupon.attributes.code,
                        discount: coupon.attributes.is_percentage ? coupon.attributes.discount : coupon.attributes.discount / 100,
                        reuse: coupon.attributes.quantity
                    })

                    this.$emit('changePage', 'new-edit-coupon')
                }
            },
            bin2hex (s) {
                let i, l, o = "", n;

                s += "";

                for (i = 0, l = s.length; i < l; i++) {
                    n = s.charCodeAt(i).toString(16)
                    o += n.length < 2 ? "0" + n : n;
                }

                return o;
            },
            random_bytes(size) {
                let text = "",
                    possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                for (let i = 0; i < size; i++)
                    text += possible.charAt(Math.floor(Math.random() * possible.length));

                return text;
            },
            deleteCoupon(coupon){
                swal({
                    title: 'Você tem certeza?',
                    text: "Ao fazer isso o cupom será apagado e qualquer que o tenha recebido não poderá utilizar mais!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, apagar!'
                }).then((result) => {
                    if (result.value) {
                        this.changeLoading(true)

                        sendAPIDELETE(`${process.env.MIX_API_VERSION_ENDPOINT}/coupons/${coupon.id}`, {})
                            .then(response => {
                                sendAlert({
                                    title: 'Tudo Certo!',
                                    message: 'Coupon removido.',
                                    type: 'success'
                                })

                                this.setCoupons(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/coupons`)
                            })
                            .catch((error) => {
                                this.changeLoading(false)
                                exceptionError(error)
                            })
                    }
                })
            }
        }
    }
</script>
